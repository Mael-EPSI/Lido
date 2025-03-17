<?php
// 1) Connexion à la base de données
$servername  = "digitalprojects.fr";
$db_username = "ceda8720";
$db_password = "c4Gt-KRWC-UCP(";
$dbname      = "ceda8720_pizza";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
  die("Erreur de connexion : " . $conn->connect_error);
}

// 2) Requête : nombre de commandes par produit
$sql = "
    SELECT p.nom AS produit_nom, COUNT(cd.produit_id) AS total_commandes
    FROM commandes_details cd
    JOIN produits p ON cd.produit_id = p.id
    GROUP BY cd.produit_id
    ORDER BY total_commandes DESC
";
$result = $conn->query($sql);

$plats = [];
$commandes = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $plats[] = $row['produit_nom'];
    $commandes[] = (int)$row['total_commandes'];
  }
}

// Requête pour prix moyen par catégorie
$sql_prix = "SELECT c.nom as categorie, AVG(p.prix) as prix_moyen 
             FROM categories c 
             JOIN produits p ON p.categorie_id = c.id 
             GROUP BY c.id";
$result_prix = $conn->query($sql_prix);

$categories = [];
$prix_moyens = [];
while ($row = $result_prix->fetch_assoc()) {
  $categories[] = $row['categorie'];
  $prix_moyens[] = round($row['prix_moyen'], 2);
}

// Requête pour nombre de clients par mois (1 commande = 1 client)
$sql_clients = "SELECT MONTH(date_commande) as mois, COUNT(*) as nb_clients 
                FROM commandes 
                WHERE YEAR(date_commande) = YEAR(CURRENT_DATE)
                GROUP BY mois
                ORDER BY mois";
$result_clients = $conn->query($sql_clients);

$mois = ["Jan", "Fév", "Mar", "Avr", "Mai", "Jun", "Jul", "Aoû", "Sep", "Oct", "Nov", "Déc"];
$nb_clients = array_fill(0, 12, 0); // Initialise tableau avec 12 zéros

while ($row = $result_clients->fetch_assoc()) {
  $nb_clients[$row['mois'] - 1] = (int)$row['nb_clients'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Graphique Commandes</title>
  <!-- Import de Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 20px;
    }

    .chart-container {
      width: 80%;
      max-width: 600px;
      margin: 0 auto;
    }

    #dishesChart {
      height: 400px;
      /* Hauteur fixe pour mieux visualiser */
    }

    h2 {
      text-align: center;
      margin: 30px 0;
    }

    nav a {
            color: black;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #ff9800;
        }
  </style>
</head>

<body>
  <nav>
    <a href="..\admin/index.php">Gestion</a>
    <a href="..\graph/graphique.php">Graphique</a>
  </nav>
  <h2>Produits les plus commandés</h2>

  <div class="chart-container">
    <canvas id="dishesChart"></canvas>
  </div>

  <h2>Prix moyen par catégorie</h2>
  <div class="chart-container">
    <canvas id="priceChart"></canvas>
  </div>

  <h2>Nombre de clients par mois</h2>
  <div class="chart-container">
    <canvas id="clientsChart"></canvas>
  </div>

  <script>
    // Données PHP converties en JSON et échappées directement dans le JavaScript
    const plats = [<?php echo "'" . implode("','", array_map('addslashes', $plats)) . "'"; ?>];
    const commandes = [<?php echo implode(",", $commandes); ?>];

    // Debug
    console.log('Plats:', plats);
    console.log('Commandes:', commandes);

    // Création du graphique
    const ctx = document.getElementById('dishesChart').getContext('2d');
    const myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: plats,
        datasets: [{
          data: commandes,
          backgroundColor: [
            '#FF6384', '#36A2EB', '#FFCE56',
            '#4BC0C0', '#9966FF', '#FF9F40',
            '#a1d99b', '#9ecae1', '#fdae6b'
          ],
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom'
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                const label = context.label || '';
                const value = context.raw || 0;
                return `${label}: ${value} commandes`;
              }
            }
          }
        }
      }
    });

    // Graphique des prix moyens
    new Chart(document.getElementById('priceChart').getContext('2d'), {
      type: 'bar',
      data: {
        labels: [<?php echo "'" . implode("','", array_map('addslashes', $categories)) . "'"; ?>],
        datasets: [{
          label: 'Prix moyen (€)',
          data: [<?php echo implode(",", $prix_moyens); ?>],
          backgroundColor: '#36A2EB'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });

    // Graphique des clients
    new Chart(document.getElementById('clientsChart').getContext('2d'), {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("','", $mois) . "'"; ?>],
        datasets: [{
          label: 'Nombre de clients',
          data: [<?php echo implode(",", $nb_clients); ?>],
          borderColor: '#FF6384',
          tension: 0.1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  </script>
</body>

</html>