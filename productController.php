<?php
//product controller
require_once 'db_connection.php';

function getAllProductsWithCategory($search = '') {
    global $pdo;
    $sql = "
        SELECT
            p.product_id,
            p.name AS product_name,
            c.name AS category_name,
            c.category_id,
            p.stock,
            p.unit_price,
            p.created_at
        FROM products p
        INNER JOIN categories c on p.category_id = c.category_id
    ";

    if(!empty($search)) {
        $sql .=" WHERE p.name LIKE :search OR c.name LIKE :search";
    }

    //$sql .= " ORDER BY p.createed_at DESC"; I intend to put sorting logic crap here. pls ignore this.
    
    $stmt = $pdo->prepare($sql);

    if(!empty($search)) {
        $term = "%$search%";
        $stmt->bindParam(':search', $term);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}
?>