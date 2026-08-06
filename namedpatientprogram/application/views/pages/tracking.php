<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php $this->load->view('layouts/includes/head-links'); ?>
</head>


<style>
    /* ================= TIMELINE ================= */

    .timeline-container {
        position: relative;
        padding-left: 24px;
    }

    .timeline-container::before {
        /* content: ''; */
        position: absolute;
        left: 6px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, #2563eb, #7c3aed);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 24px;
        padding: 18px;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .timeline-item:hover {
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        transform: translateX(4px);
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -18px;
        top: 22px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #2563eb;
        border: 4px solid #ffffff;
        box-shadow: 0 0 0 2px #2563eb;
        z-index: 1;
    }

    .timeline-item.type-international::before {
        background: #2563eb;
        box-shadow: 0 0 0 2px #2563eb;
    }

    .timeline-item.type-domestic::before {
        background: #10b981;
        box-shadow: 0 0 0 2px #10b981;
    }

    .timeline-item.type-custom::before {
        background: #f59e0b;
        box-shadow: 0 0 0 2px #f59e0b;
    }

    .timeline-item.type-message::before {
        background: #8b5cf6;
        box-shadow: 0 0 0 2px #8b5cf6;
    }

    /* ================= BADGES ================= */

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-international {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-domestic {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-custom {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-message {
        background: #ede9fe;
        color: #5b21b6;
    }

    /* ================= HEADER ================= */

    .tracking-header {
        background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        padding: 3rem 0;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
    }

    .info-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .custom-message-highlight {
        background: linear-gradient(135deg, #7c3aed 0%, #c026d3 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 20px rgba(124, 58, 237, 0.3);
    }

    @media (max-width: 768px) {
        .timeline-container {
            padding-left: 18px;
        }

        .timeline-item::before {
            left: -14px;
        }

        .tracking-header {
            padding: 2rem 0;
        }
    }
</style>

<body>
    <div class="min-h-screen bg-gray-50">
        <?php $this->load->view('layouts/includes/header'); ?>
        <!-- Header -->
        <div class="tracking-header">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-3">
                    <i class="fas fa-shipping-fast mr-3"></i>Track Your Shipment
                </h1>
                <p class="text-blue-100 text-lg">Real-time tracking updates for your order</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-6 pb-12">

            <?php if (!empty($error)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-5 rounded-lg mb-6 flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-2xl"></i>
                    <div>
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline"><?= htmlspecialchars($error); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($tracking_data)): ?>

                <!-- INFO CARDS -->
                <div class="grid md:grid-cols-3 gap-5 mb-8">
                    <div class="info-card">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                            <p class="text-sm text-gray-500 font-semibold">Invoice Number</p>
                        </div>
                        <p class="text-xl font-bold text-gray-800">
                            <?= htmlspecialchars($tracking_data['invoice_number'] ?? $invoice_number); ?>
                        </p>
                    </div>

                    <div class="info-card">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-user-circle text-green-600 text-xl"></i>
                            <p class="text-sm text-gray-500 font-semibold">Customer Name</p>
                        </div>
                        <p class="text-xl font-bold text-gray-800">
                            <?= htmlspecialchars($tracking_data['customer_name'] ?? 'N/A'); ?>
                        </p>
                    </div>

                    <div class="info-card">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-info-circle text-purple-600 text-xl"></i>
                            <p class="text-sm text-gray-500 font-semibold">Current Status</p>
                        </div>
                        <p class="text-xl font-bold text-green-600">
                            <?= htmlspecialchars($tracking_data['status'] ?? 'In Progress'); ?>
                        </p>
                    </div>
                </div>

                <!-- TIMELINE -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-md">
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fas fa-route text-2xl text-blue-600"></i>
                        <h2 class="text-2xl font-bold text-gray-800">
                            Shipment Timeline
                        </h2>
                    </div>

                    <div class="timeline-container">

                        <?php if (empty($timeline)): ?>
                            <div class="text-center py-12">
                                <i class="fas fa-box-open text-gray-300 text-6xl mb-4"></i>
                                <p class="text-gray-500 text-lg font-semibold">
                                    No tracking updates available yet.
                                </p>
                                <p class="text-gray-400 text-sm mt-2">
                                    Please check back later for updates.
                                </p>
                            </div>
                        <?php else: ?>

                            <?php foreach ($timeline as $event): ?>
                                <?php
                                $type_class = 'type-' . strtolower($event['type']);
                                $badge_class = 'badge-' . strtolower($event['type']);

                                $icon_map = [
                                    'International' => 'fa-plane',
                                    'Domestic' => 'fa-truck',
                                    'Custom' => 'fa-file-contract',
                                    'Message' => 'fa-bell'
                                ];

                                $icon = $icon_map[$event['type']] ?? 'fa-box';
                                ?>

                                <div class="timeline-item <?= $type_class ?>">
                                    <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-3 gap-2">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <!-- <span class="badge <?= $badge_class ?>">
                                <i class="fas <?= $icon ?> mr-1"></i>
                                <?= htmlspecialchars($event['type']); ?>
                            </span> -->
                                            <h3 class="text-lg font-bold text-gray-800">
                                                <?= htmlspecialchars($event['location']); ?>
                                            </h3>
                                        </div>

                                        <div class="text-sm text-gray-500 font-semibold">
                                            <?php
                                            if (!empty($event['datetime'])) {
                                                try {
                                                    $d = new DateTime($event['datetime']);
                                                    echo '<i class="far fa-clock mr-1"></i>';
                                                    echo $d->format('M d, Y • h:i A');
                                                } catch (Exception $e) {
                                                    echo 'N/A';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-lg border-l-4 <?php
                                    echo $event['type'] === 'Message' ? 'border-purple-500' : ($event['type'] === 'International' ? 'border-blue-500' : ($event['type'] === 'Domestic' ? 'border-green-500' : 'border-yellow-500'));
                                    ?>">
                                        <p
                                            class="text-gray-700 leading-relaxed <?php echo $event['type'] === 'Message' ? 'font-semibold' : ''; ?>">
                                            <?= nl2br(htmlspecialchars($event['status'])); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>
                </div>

                <!-- PDF DOWNLOAD -->
                <?php if (!empty($tracking_data['pdf_file_path'])): ?>
                    <div class="mt-8 text-center">
                        <a href="<?= htmlspecialchars($tracking_data['pdf_file_path']); ?>" target="_blank"
                            class="inline-flex items-center gap-3 px-8 py-4 bg-red-600 text-white font-bold text-lg rounded-lg hover:bg-red-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fas fa-file-pdf text-2xl"></i>
                            <span>Download Invoice (PDF)</span>
                        </a>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

            <?php if (($source ?? '') !== 'app'): ?>
                <!-- BACK TO HOME -->
                <div class="mt-8 text-center">
                    <a href="<?= base_url(); ?>"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Home</span>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <script>
        console.log('Tracking page loaded successfully.');
        console.log('Tracking Data:', <?= json_encode($tracking_data); ?>);
    </script>

    <?php $this->load->view('layouts/includes/footer'); ?>

</body>

</html>
