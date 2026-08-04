<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Medicine_Model extends CI_Model
{
    protected $table = 'medicians';

    /**
     * ========================================
     * NEW METHODS FOR A-Z BROWSING
     * ========================================
     */

    /**
     * Get count of medicines per alphabet letter
     * Optionally filter by category
     * 
     * @param int|null $category_id
     * @return array ['A' => 5, 'B' => 12, ...]
     */

    public function getMedicineBySlug($category, $medicine)
    {
        $this->db->select('m.*, c.name as category_name');
        $this->db->from('medicians m');
        $this->db->join('med_categories c', 'c.id = m.category_id');

        $results = $this->db->get()->result();
        $this->load->helper('slug');

        foreach ($results as $row) {

            $cat_slug = create_slug($row->category_name);
            $med_slug = create_slug($row->name);

            if ($cat_slug === $category && $med_slug === $medicine) {
                return $row;
            }
        }

        return null;
    }


    public function getAlphabetStats($category_id = null)
    {
        $this->db->select('UPPER(SUBSTRING(name, 1, 1)) as letter, COUNT(*) as count', FALSE);
        $this->db->from($this->table);

        if ($category_id) {
            $this->db->where('category_id', (int) $category_id);
        }

        $this->db->group_by('letter');
        $this->db->order_by('letter', 'ASC');

        $query = $this->db->get();

        $stats = [];
        foreach ($query->result() as $row) {
            // Only include A-Z letters
            if (preg_match('/^[A-Z]$/', $row->letter)) {
                $stats[$row->letter] = (int) $row->count;
            }
        }

        return $stats;
    }

    /**
     * Get medicines grouped by starting letter
     * Supports filtering by letter and/or category
     * 
     * @param string|null $letter Single letter A-Z
     * @param int|null $category_id
     * @return array ['A' => [medicines], 'B' => [medicines], ...]
     */
    public function getMedicinesGroupedByLetter($letter = null, $category_id = null)
    {
        $this->db->select('medicians.*, med_categories.name as category_name');
        $this->db->from($this->table);
        $this->db->join('med_categories', 'med_categories.id = medicians.category_id', 'left');

        // Filter by letter if provided
        if ($letter && preg_match('/^[A-Z]$/', $letter)) {
            // Use LIKE for better compatibility
            $this->db->like('medicians.name', $letter, 'after');
        }

        // Filter by category if provided
        if ($category_id) {
            $this->db->where('medicians.category_id', (int) $category_id);
        }

        $this->db->order_by('medicians.name', 'ASC');

        $query = $this->db->get();
        $medicines = $query->result();

        // Group by first letter and filter only A-Z
        $grouped = [];
        foreach ($medicines as $medicine) {
            $first_letter = strtoupper(substr($medicine->name, 0, 1));

            // Only include medicines starting with A-Z
            if (preg_match('/^[A-Z]$/', $first_letter)) {
                if (!isset($grouped[$first_letter])) {
                    $grouped[$first_letter] = [];
                }
                $grouped[$first_letter][] = $medicine;
            }
        }

        // Sort by letter
        ksort($grouped);

        return $grouped;
    }

    /**
     * ========================================
     * EXISTING SEARCH METHODS
     * ========================================
     */

    // public function searchMedicines($search_term, $limit = null, $offset = 0)
    // {
    //     $this->db->from($this->table);

    //     $this->db->group_start();
    //     $this->db->like('name', $search_term);
    //     $this->db->or_like('active_ingredient', $search_term);
    //     $this->db->or_like('strength', $search_term);
    //     $this->db->or_like('storage', $search_term);
    //     $this->db->or_like('company_name', $search_term);
    //     $this->db->group_end();

    //     $this->db->order_by('name', 'ASC');

    //     if ($limit !== null) {
    //         $this->db->limit($limit, $offset);
    //     }

    //     return $this->db->get()->result();
    // }


    public function searchMedicines($search_term, $limit = null, $offset = 0)
    {
        $this->db->select('
        medicines.*, 
        med_categories.name as category_name
    ');

        $this->db->from($this->table . ' as medicines');

        // JOIN with category table
        $this->db->join('med_categories', 'med_categories.id = medicines.category_id', 'left');

        // Search filters
        $this->db->group_start();
        $this->db->like('medicines.name', $search_term);
        $this->db->or_like('medicines.active_ingredient', $search_term);
        $this->db->or_like('medicines.strength', $search_term);
        $this->db->or_like('medicines.storage', $search_term);
        $this->db->or_like('medicines.company_name', $search_term);
        $this->db->group_end();

        $this->db->order_by('medicines.name', 'ASC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    public function countSearchMedicines($search_term)
    {
        $this->db->from($this->table);

        $this->db->group_start();
        $this->db->like('name', $search_term);
        $this->db->or_like('active_ingredient', $search_term);
        $this->db->or_like('strength', $search_term);
        $this->db->or_like('storage', $search_term);
        $this->db->or_like('company_name', $search_term);
        $this->db->group_end();

        return $this->db->count_all_results();
    }

    public function getAllMedicines($limit = 20, $offset = 0)
    {
        $this->db->from($this->table);
        $this->db->order_by('name', 'ASC');
        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }

    public function countAllMedicines()
    {
        return $this->db->count_all($this->table);
    }

    public function getMedicineById($id)
    {
        $this->db->from($this->table);
        $this->db->where('id', (int) $id);
        return $this->db->get()->row();
    }

    public function getMedicineImages($id)
    {
        $this->db->where('id', $id);
        $this->db->order_by('id', 'ASC');
        return $this->db->get('medicians')->result();
    }

    public function getRelatedMedicines($category_id, $exclude_id, $limit = 4)
    {
        $this->db->select('m.*, c.name as category_name'); // select fields you need
        $this->db->from($this->table . ' m');

        // Join with category table
        $this->db->join('med_categories c', 'c.id = m.category_id', 'left');

        $this->db->where('m.category_id', $category_id);
        $this->db->where('m.id !=', $exclude_id);

        $this->db->order_by('RAND()');
        $this->db->limit($limit);

        return $this->db->get()->result();
    }
    public function getMedicinesByCategory($category_id, $limit = 20, $offset = 0)
    {
        $this->db->from($this->table);
        $this->db->where('category_id', $category_id);
        $this->db->order_by('name', 'ASC');
        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }

    public function countMedicinesByCategory($category_id)
    {
        return $this->db->where('category_id', $category_id)->count_all_results($this->table);
    }

    /**
     * ========================================
     * ADMIN METHODS
     * ========================================
     */

    public function adminCountAll()
    {
        return (int) $this->db->count_all($this->table);
    }

    // public function getAdminPaginated($limit, $offset)
    // {
    //     $this->db->order_by('id', 'DESC');

    //     if ((int) $limit > 0) {
    //         $this->db->limit((int) $limit, (int) $offset);
    //     }

    //     return $this->db->get($this->table)->result();
    // }

    public function getAdminPaginated($limit = 0, $offset = 0, $category_id = '')
    {
        $this->db->select('medicians.*, med_categories.name as category_name');
        $this->db->from($this->table);
        $this->db->join('med_categories', 'med_categories.id = medicians.category_id', 'left');

        // Filter by category
        if (!empty($category_id)) {
            $this->db->where('medicians.category_id', (int) $category_id);
        }

        $this->db->order_by('medicians.id', 'DESC');

        if ((int) $limit > 0) {
            $this->db->limit((int) $limit, (int) $offset);
        }

        return $this->db->get()->result();
    }
    public function insertMedicine($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function updateMedicine($id, $data)
    {
        return $this->db->where('id', (int) $id)->update($this->table, $data);
    }

    public function deleteMedicine($id)
    {
        return $this->db->where('id', (int) $id)->delete($this->table);
    }

    // Bulk Delete
    public function bulkDelete($ids)
    {
        if (empty($ids)) {
            return false;
        }

        $this->db->where_in('id', $ids);
        return $this->db->delete('medicians');
    }

    public function getById($id)
    {
        return $this->getMedicineById($id);
    }

    /**
     * ========================================
     * HOMEPAGE METHODS
     * ========================================
     */

    // public function getHomePatentMedicines($limit = 12)
    // {
    //     return $this->db
    //         ->where('show_on_home', 1)
    //         ->order_by('id', 'DESC')
    //         ->limit((int)$limit)
    //         ->get($this->table)
    //         ->result();
    // }

    public function getHomePatentMedicines($limit = 12)
    {
        return $this->db
            ->select('m.*, c.name as category_name') // add required category columns
            ->from($this->table . ' m')
            ->join('med_categories c', 'c.id = m.category_id', 'left')
            ->where('m.show_on_home', 1)
            ->order_by('m.id', 'DESC')
            ->limit((int) $limit)
            ->get()
            ->result();
    }
    public function getHomeSelectedIds()
    {
        $rows = $this->db->select('id')
            ->from($this->table)
            ->where('show_on_home', 1)
            ->get()
            ->result();

        $ids = [];
        foreach ($rows as $r) {
            $ids[] = (int) $r->id;
        }
        return $ids;
    }

    public function resetHomeSelection()
    {
        $this->db->set('show_on_home', 0)->update($this->table);
    }

    public function setHomeSelection(array $ids)
    {
        if (empty($ids))
            return;

        $this->db->where_in('id', $ids)
            ->set('show_on_home', 1)
            ->update($this->table);
    }

    public function getAllCategories()
    {
        return $this->db->get("med_categories")->result();
    }

    /**
     * ========================================
     * LEGACY METHODS (for backward compatibility)
     * ========================================
     */

    public function insertNews($data)
    {
        $this->db->insert("medicians", $data);
    }

    public function updateNews($id, $data)
    {
        return $this->db->where("id", $id)->update("medicians", $data);
    }

    public function countAllNews()
    {
        return $this->db->count_all('medicians');
    }

    public function getNewsPaginated($limit, $offset)
    {
        $this->db->select("medicians.*, med_categories.name as category_name");
        $this->db->from("medicians");
        $this->db->join("med_categories", "med_categories.id = medicians.category_id", "left");
        $this->db->order_by("medicians.id", "DESC");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }

    public function getNewsBySlug($name)
    {
        $this->db->select("medicians.*, medicians.created_at as created_at, medicians.name as title, med_categories.name as category");
        $this->db->from("medicians");
        $this->db->join("med_categories", "med_categories.id = medicians.category_id", "left");
        $this->db->where("medicians.name", $name);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getMedicinesByCategoryPaginated($category_id, $limit, $offset)
    {
        $this->db->select("medicians.*, med_categories.name as category_name");
        $this->db->from("medicians");
        $this->db->join("med_categories", "med_categories.id = medicians.category_id", "left");
        $this->db->where("medicians.category_id", $category_id);
        $this->db->order_by("medicians.id", "DESC");
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    public function importMedicinesFromCSV($csv_path)
    {
        $success_count = 0;
        $failed_count = 0;
        $errors = [];

        log_message('info', '=== Starting CSV Import ===');
        log_message('info', 'File: ' . $csv_path);

        if (!file_exists($csv_path)) {
            throw new Exception("CSV file not found: " . $csv_path);
        }

        // Avoid PHP execution/memory limits killing large imports silently
        @set_time_limit(300);
        @ini_set('memory_limit', '512M');

        // --- Sanitize the file before parsing ---
        // Fixes: BOM, mixed line endings (\r only from old Mac/Excel exports),
        // and stray null bytes that can corrupt fgetcsv() field boundaries.
        $raw = file_get_contents($csv_path);
        if ($raw === false) {
            throw new Exception("Unable to read CSV file: " . $csv_path);
        }

        // Strip UTF-8 BOM if present
        $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw);

        // Normalize all line endings to \n
        $raw = str_replace(["\r\n", "\r"], "\n", $raw);

        // Remove stray null bytes
        $raw = str_replace("\0", '', $raw);

        $clean_path = $csv_path . '.clean.csv';
        file_put_contents($clean_path, $raw);

        $handle = fopen($clean_path, 'r');
        if ($handle === false) {
            throw new Exception("Unable to open sanitized CSV file");
        }

        // Read headers
        $headers = fgetcsv($handle, 0, ',');
        if ($headers === false) {
            fclose($handle);
            @unlink($clean_path);
            throw new Exception("Failed to read CSV headers");
        }

        $headers = array_map(function ($h) {
            return strtolower(trim($h, " \t\n\r\0\x0B\""));
        }, $headers);

        log_message('info', 'CSV Headers: ' . implode(', ', $headers));

        $required_columns = ['name', 'category_id', 'strength'];
        foreach ($required_columns as $req_col) {
            if (!in_array($req_col, $headers)) {
                fclose($handle);
                @unlink($clean_path);
                throw new Exception("Missing required column: '{$req_col}'. Found: " . implode(', ', $headers));
            }
        }

        $col_map = array_flip($headers);
        $expected_col_count = count($headers);

        $categories = $this->db->get('med_categories')->result_array();
        $valid_category_ids = array_column($categories, 'id');
        log_message('info', 'Valid category IDs: ' . implode(', ', $valid_category_ids));

        $row_number = 1;      // header = row 1
        $lines_read = 0;      // sanity counter

        // Don't let one bad DB row roll back everything already inserted
        $this->db->trans_strict(FALSE);
        $this->db->trans_start();

        while (($data = fgetcsv($handle, 0, ',')) !== false) {
            $row_number++;
            $lines_read++;

            try {
                // Detect a row that came out shorter/longer than the header —
                // a strong sign fgetcsv merged/misaligned fields due to a stray quote.
                if (count($data) !== $expected_col_count) {
                    $errors[] = "Row {$row_number}: Column count mismatch (expected {$expected_col_count}, got " . count($data) . "). Likely an unescaped quote/comma in this or the previous row.";
                    $failed_count++;
                    log_message('error', "Row {$row_number}: Column count mismatch");
                    continue;
                }

                // Now check for genuinely empty rows (not the mismatch case above)
                if (
                    empty(array_filter($data, function ($val) {
                        return trim($val) !== '';
                    }))
                ) {
                    log_message('info', "Row {$row_number}: Empty row, skipping");
                    continue; // truly blank lines are fine to skip uncounted
                }

                $name = isset($col_map['name']) ? trim($data[$col_map['name']] ?? '') : '';
                $category_id = isset($col_map['category_id']) ? trim($data[$col_map['category_id']] ?? '') : '';
                $strength = isset($col_map['strength']) ? trim($data[$col_map['strength']] ?? '') : '';

                if (empty($name)) {
                    $errors[] = "Row {$row_number}: Name is required";
                    $failed_count++;
                    continue;
                }

                if (empty($category_id) || !is_numeric($category_id)) {
                    $errors[] = "Row {$row_number}: Invalid category_id ('{$category_id}')";
                    $failed_count++;
                    continue;
                }

                if (empty($strength)) {
                    $errors[] = "Row {$row_number}: Strength is required";
                    $failed_count++;
                    continue;
                }

                if (!in_array((int) $category_id, $valid_category_ids)) {
                    $errors[] = "Row {$row_number}: Category ID {$category_id} does not exist";
                    $failed_count++;
                    continue;
                }

                $insert_data = [
                    'name' => $name,
                    'category_id' => (int) $category_id,
                    'strength' => $strength,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $optional_fields = [
                    'price' => 'float',
                    'company_name' => 'string',
                    'active_ingredient' => 'string',
                    'how_supplied' => 'string',
                    'storage' => 'string',
                    'dosage_form' => 'string',
                    'pack_size' => 'string',
                    'origin' => 'string',
                    'detail' => 'string',
                    'note' => 'string',
                    'source_url' => 'string',
                    'medical_uses' => 'string',
                    'warning_precautions' => 'string',
                    'documentation_availability' => 'string',
                    'sourcing_delivery' => 'string',
                    'faq' => 'string',
                    'disclaimer' => 'string',
                ];

                foreach ($optional_fields as $field => $type) {
                    if (isset($col_map[$field]) && isset($data[$col_map[$field]])) {
                        $value = trim($data[$col_map[$field]]);
                        if ($value !== '') {
                            $insert_data[$field] = ($type === 'float') ? (float) $value : $value;
                        }
                    }
                }

                if (isset($col_map['on_request']) && isset($data[$col_map['on_request']])) {
                    $value = strtolower(trim($data[$col_map['on_request']]));
                    $insert_data['on_request'] = in_array($value, ['yes', '1', 'true', 'y']) ? 1 : 0;
                }

                $this->db->insert($this->table, $insert_data);

                if ($this->db->affected_rows() > 0) {
                    $success_count++;
                } else {
                    $failed_count++;
                    $db_error = $this->db->error();
                    $errors[] = "Row {$row_number}: Database error: " . ($db_error['message'] ?? 'Unknown error');
                    log_message('error', "Row {$row_number}: Insert failed - " . ($db_error['message'] ?? ''));
                }
            } catch (Exception $e) {
                $failed_count++;
                $errors[] = "Row {$row_number}: " . $e->getMessage();
                log_message('error', "Row {$row_number}: Exception - " . $e->getMessage());
            }
        }

        fclose($handle);
        @unlink($clean_path);

        $this->db->trans_complete();

        log_message('info', "Total data lines read from file: {$lines_read}");
        log_message('info', "=== Import Complete === Success: {$success_count}, Failed: {$failed_count}");

        if ($this->db->trans_status() === false) {
            log_message('error', 'Transaction reported failure');
            return [
                'success' => 0,
                'failed' => $failed_count,
                'errors' => array_merge(['Transaction failed - some changes may not have been saved'], $errors),
            ];
        }

        return [
            'success' => $success_count,
            'failed' => $failed_count,
            'errors' => $errors,
        ];
    }
}