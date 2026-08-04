<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tracking extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'text']);
        $this->load->model('settings_model');
    }

    /**
     * Display tracking form and process tracking request
     */
    public function index()
    {
        $invoice_number = $this->input->get('invoice') ?? $this->input->post('invoice');

        $data = [
            'invoice_number' => $invoice_number,
            'tracking_data' => null,
            'error' => null,
            'timeline' => []
        ];

        // If invoice number provided, fetch tracking data
        if (!empty($invoice_number)) {
            $result = $this->fetch_tracking_data($invoice_number);

            if ($result['success']) {
                $data['tracking_data'] = $result['data'];
                $data['timeline'] = $this->build_unified_timeline($result['data']);
            } else {
                $data['error'] = $result['error'];
            }
        }

        $this->load->view('pages/tracking', $data);
    }

    /**
     * Fetch tracking data from API
     */
    private function fetch_tracking_data($invoice_number)
    {
        $api_url = 'https://trackorder.ikrispharmanetwork.com/api/track';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['invoice_number' => $invoice_number]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($response === false || $http_code !== 200) {
            return [
                'success' => false,
                'error' => 'Unable to connect to tracking service. Please try again later.'
            ];
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'error' => 'Invalid response from tracking service.'
            ];
        }

        return [
            'success' => true,
            'data' => $data
        ];
    }

    /**
     * Build unified timeline from all tracking sources
     * Sorted in ASCENDING order (oldest first)
     */
    private function build_unified_timeline($data)
    {
        $timeline = [];

        // Parse International Shipment Events (DHL/FedEx → Ikris)
        if (isset($data['internationalData']['data'])) {
            $int_data = $data['internationalData']['data'];

            // DHL format
            if (!empty($int_data['shipments'][0]['events'])) {
                foreach ($int_data['shipments'][0]['events'] as $event) {
                    $timeline[] = [
                        'timestamp' => strtotime($event['timestamp'] ?? 'now'),
                        'datetime' => $event['timestamp'] ?? '',
                        'location' => $event['location']['address']['addressLocality'] ?? 'Warehouse',
                        'status' => $this->replace_fedex($event['description'] ?? 'In Transit'),
                        'type' => 'International'
                    ];
                }
            }

            // FedEx format → Replace with Ikris
            if (!empty($int_data['output']['completeTrackResults'][0]['trackResults'][0]['scanEvents'])) {
                foreach ($int_data['output']['completeTrackResults'][0]['trackResults'][0]['scanEvents'] as $event) {
                    $location = $event['scanLocation']['city'] ??
                        $event['scanLocation']['countryName'] ?? 'Warehouse';

                    $timeline[] = [
                        'timestamp' => strtotime($event['date'] ?? 'now'),
                        'datetime' => $event['date'] ?? '',
                        'location' => $location,
                        'status' => $this->replace_fedex($event['eventDescription'] ?? 'In Transit'),
                        'type' => 'International'
                    ];
                }
            }
        }

        // Parse Domestic Shipment Events
        if (isset($data['domestic']['data'])) {
            $dom_data = $data['domestic']['data'];

            if (!empty($dom_data['shipments'][0]['events'])) {
                foreach ($dom_data['shipments'][0]['events'] as $event) {
                    $timeline[] = [
                        'timestamp' => strtotime($event['timestamp'] ?? $event['date'] ?? 'now'),
                        'datetime' => $event['timestamp'] ?? $event['date'] ?? '',
                        'location' => $event['location'] ?? $event['city'] ?? 'Unknown Location',
                        'status' => $event['status'] ?? $event['Job'] ?? 'Processing',
                        'type' => 'Domestic'
                    ];
                }
            } elseif (is_array($dom_data)) {
                foreach ($dom_data as $event) {
                    $timeline[] = [
                        'timestamp' => strtotime($event['Date'] ?? $event['date'] ?? $event['timestamp'] ?? 'now'),
                        'datetime' => $event['Date'] ?? $event['date'] ?? $event['timestamp'] ?? '',
                        'location' => $event['Location'] ?? $event['location'] ?? $event['city'] ?? 'Unknown Location',
                        'status' => $event['Status'] ?? $event['status'] ?? $event['Job'] ?? 'Processing',
                        'type' => 'Domestic'
                    ];
                }
            }
        }

        // Parse Custom Delivery Data
        if (!empty($data['custom_deliverydata']) && is_array($data['custom_deliverydata'])) {
            foreach ($data['custom_deliverydata'] as $custom) {
                $timeline[] = [
                    'timestamp' => strtotime($custom['datetime'] ?? 'now'),
                    'datetime' => $custom['datetime'] ?? '',
                    'location' => $custom['location'] ?? 'Custom Clearance',
                    'status' => $custom['status'] ?? 'Processing',
                    'type' => 'Custom'
                ];
            }
        }

        // Add Custom Message with updated title
        if (!empty($data['custom_message'])) {
            $custom_message = $this->format_custom_message($data['custom_message']);

            $timeline[] = [
                'timestamp' => strtotime($custom['datetime'] ?? 'now'),
                'datetime' => date('Y-m-d H:i:s'),
                'location' => 'Important Update',
                'status' => $custom_message,
                'type' => 'Message'
            ];
        }

        // Sort by timestamp ASCENDING (oldest to newest)
        usort($timeline, function ($a, $b) {
            return $a['timestamp'] - $b['timestamp'];
        });

        return $timeline;
    }

    /**
     * Replace "FedEx" with "Ikris" (case-insensitive)
     */
    private function replace_fedex($text)
    {
        return str_ireplace('FedEx', 'Ikris', $text);
    }

    /**
     * Format custom message with updated title
     */
    private function format_custom_message($message)
    {
        // Replace various forms of the message title
        $patterns = [
            '/The shipment has arrived at Indian customs and has been handed over for domestic delivery/i',
            '/The shipment has arrived at indian customs and has been handed over for domestic delivery/i',
            '/shipment has arrived at Indian customs/i',
        ];

        $replacement = 'THE SHIPMENT HAS ARRIVED AT INDIAN CUSTOMS AND HAS BEEN HANDED OVER FOR DOMESTIC DELIVERY';

        foreach ($patterns as $pattern) {
            $message = preg_replace($pattern, $replacement, $message);
        }

        return $message;
    }

    /**
     * AJAX endpoint for live tracking
     */
    public function ajax_track()
    {
        header('Content-Type: application/json');

        $invoice_number = $this->input->post('invoice_number');

        if (empty($invoice_number)) {
            echo json_encode([
                'success' => false,
                'error' => 'Invoice number is required'
            ]);
            return;
        }

        $result = $this->fetch_tracking_data($invoice_number);

        if ($result['success']) {
            $result['data']['timeline'] = $this->build_unified_timeline($result['data']);
        }

        echo json_encode($result);
    }
}