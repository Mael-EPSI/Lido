<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

$pdo = require 'db.php';

try {
    // Modification de la requête pour inclure les commandes 'pret'
    $sql = "SELECT 
                c.id as commande_id,
                c.table_id,
                c.statut,
                GROUP_CONCAT(DISTINCT p.nom) as produits,
                GROUP_CONCAT(DISTINCT m.nom) as menus_noms,
                GROUP_CONCAT(DISTINCT m.id) as menus_ids
            FROM commandes c
            LEFT JOIN commandes_details cd ON c.id = cd.commande_id
            LEFT JOIN produits p ON cd.produit_id = p.id
            LEFT JOIN commandes_menus cm ON c.id = cm.commande_id
            LEFT JOIN menus m ON cm.menu_id = m.id
            WHERE c.statut IN ('en cours', 'pret')
            GROUP BY c.id";

    $stmt = $pdo->query($sql);
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($commandes as &$commande) {
        // Traitement des produits
        $commande['produits'] = $commande['produits'] ? explode(',', $commande['produits']) : [];

        // Traitement des menus
        $menus_noms = $commande['menus_noms'] ? explode(',', $commande['menus_noms']) : [];
        $menus_ids = $commande['menus_ids'] ? explode(',', $commande['menus_ids']) : [];
        
        $menus = [];
        for ($i = 0; $i < count($menus_ids); $i++) {
            // Récupérer les produits du menu
            $sql_produits = "SELECT p.nom 
                           FROM commandes_menus_details cmd
                           JOIN produits p ON cmd.produit_id = p.id
                           WHERE cmd.commande_id = ? AND cmd.menu_id = ?";
            $stmt_produits = $pdo->prepare($sql_produits);
            $stmt_produits->execute([$commande['commande_id'], $menus_ids[$i]]);
            $produits_menu = $stmt_produits->fetchAll(PDO::FETCH_COLUMN);

            $menus[] = [
                'id' => $menus_ids[$i],
                'nom' => $menus_noms[$i],
                'produits' => $produits_menu
            ];
        }
        
        $commande['menus'] = $menus;
        unset($commande['menus_noms'], $commande['menus_ids']);
    }

    echo json_encode([
        "success" => true,
        "commandes" => $commandes
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur lors de la récupération des commandes: " . $e->getMessage()
    ]);
}
?>

