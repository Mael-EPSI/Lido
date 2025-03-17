<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$pdo = require 'db.php';

// Capture des erreurs fatales et warnings
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error) {
        echo json_encode(["success" => false, "message" => "Erreur fatale", "details" => $error]);
    }
});

// Récupérer et décoder les données JSON envoyées par le front-end
$data = json_decode(file_get_contents("php://input"), true);

// Vérifier si les données sont bien reçues
if (
    !$data 
    || !isset($data['table_id']) 
    || !isset($data['produits']) 
    || !isset($data['menus'])
) {
    echo json_encode(["success" => false, "message" => "Données manquantes ou invalides", "reçu" => $data]);
    exit;
}

try {
    // Vérifier si on a un ID de commande existante
    $commande_id = isset($data['commande_id']) ? $data['commande_id'] : null;

    if ($commande_id) {
        // Vérifier si la commande existe et est toujours "en cours"
        $check_query = "SELECT id FROM commandes WHERE id = ? AND statut = 'en cours'";
        $check_stmt = $pdo->prepare($check_query);
        $check_stmt->execute([$commande_id]);
        
        if (!$check_stmt->fetch()) {
            // La commande n'existe pas ou n'est plus en cours
            $commande_id = null;
        }
    }

    if (!$commande_id) {
        // Créer une nouvelle commande
        $insert_cmd = "INSERT INTO commandes (table_id, date_commande, statut) 
                      VALUES (?, NOW(), 'en cours')";
        $stmt = $pdo->prepare($insert_cmd);
        $stmt->execute([$data['table_id']]);
        $commande_id = $pdo->lastInsertId();
    }

    // Ajouter les nouveaux produits
    if (!empty($data['produits'])) {
        $detail_query = "INSERT INTO commandes_details (commande_id, produit_id, prix_unitaire)
                        VALUES (?, ?, ?)";
        $detail_stmt = $pdo->prepare($detail_query);

        foreach ($data['produits'] as $produit) {
            $detail_stmt->execute([$commande_id, $produit['id'], $produit['prix']]);
        }
    }

    // Ajouter les nouveaux menus
    if (!empty($data['menus'])) {
        $menu_query = "INSERT INTO commandes_menus (commande_id, menu_id, prix) 
                      VALUES (?, ?, ?)";
        $menu_stmt = $pdo->prepare($menu_query);

        $menu_detail_query = "INSERT INTO commandes_menus_details (commande_id, menu_id, produit_id, prix, type)
                            VALUES (?, ?, ?, ?, ?)";
        $menu_detail_stmt = $pdo->prepare($menu_detail_query);

        foreach ($data['menus'] as $menu) {
            $menu_stmt->execute([$commande_id, $menu['id'], $menu['prix']]);

            if (!empty($menu['produits'])) {
                foreach ($menu['produits'] as $produit_id) {
                    $menu_detail_stmt->execute([$commande_id, $menu['id'], $produit_id, 0, 'plat']);
                }
            }
        }
    }

    echo json_encode([
        "success" => true,
        "message" => "Commande mise à jour avec succès",
        "commande_id" => $commande_id
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur serveur: " . $e->getMessage()
    ]);
}
?>
