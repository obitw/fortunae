<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <style>
        <?php require __DIR__ . "/../../../ressource/style/stats.css"; ?>
    </style>
</head>
<body>

<script src=
        "https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script
        src=
        "https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"
        type="text/javascript"
></script>
<script src=
        "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src=
        "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js"></script>

<article class="container">
        <div class="frequence">
            <br>
            <h2>Frequentations des Joueurs de la Semaine</h2>
            <br>
            <canvas id="myChart"></canvas>
            <br>
        </div>
</article>
<article class="container">
        <div class="gains">
            <br>
            <h2>Les Gains du Jour</h2>
            <br>
            <canvas class="pieChart" id="myPieChart"></canvas>
            <br>
        </div>
    </article>
<article class="container">
    <!-- "Les plus grosses sommes gagnées" -->
    <div class="stat">
        <br>
        <h2>Les Plus Grosses Sommes Gagnées</h2>
        <br>
        <canvas id="myHorizontalBarChart"></canvas>
        <br>
    </div>
</article>
<article class="container">
    <div>
        <br>
        <h2>Parties Jouées</h2>
        <br>
        <!-- Table for "Les Parties" -->
        <table class="table">
            <thead>
            <tr>
                <th class="donner" scope="col">Les Parties </th>
                <th scope="col">Nombres</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="donner">Nombre de partie pour la machine à sous pour aujourd'hui</td>
                <!-- New column data (no conversion needed for count) -->
                <td><?php echo $nbPartiesJour; ?></td>
            </tr>
            <tr>
                <td class="donner">Nombre de partie pour la machine à sous depuis le lancement</td>
                <!-- New column data (no conversion needed for count) -->
                <td><?php echo $nbPartiesTotal; ?></td>
            </tr>
            </tbody>
        </table>
        <br>
    </div>
</article>
<article class="container">
    <div>
        <br>
        <h2>Tableau des Informations</h2>
        <br>

        <!-- Table for main information -->
        <table class="table">
            <thead>
            <tr>
                <th class="donner" scope="col">Type d'Information</th>
                <th scope="col">Valeur</th>
                <!-- New column -->
                <th scope="col">Valeur en euros</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="donner">Gain Maximum pour la machine à sous pour aujourd'hui</td>
                <td><?php echo $meilleurGain; ?> F</td>
                <!-- New column data -->
                <td><?php echo $meilleurGainE; ?> €</td>
            </tr>
            <tr>
                <td class="donner">Gain moyen des joueurs pour la machine à sous</td>
                <td><?php echo $gainMoyen; ?> F</td>
                <!-- New column data -->
                <td><?php echo $gainMoyenE; ?> €</td>
            </tr>
            <tr>
                <td class="donner">Mise moyenne pour la machine à sous</td>
                <td><?php echo $miseMoyenne; ?> F</td>
                <!-- New column data -->
                <td><?php echo $miseMoyenneE; ?> €</td>
            </tr>
            <tr class="highlight-row">
                <td class="donner">Total des Bénéfices depuis le lancement</td>
                <td><?php echo $benefice; ?> F</td>
                <!-- New column data -->
                <td><?php echo $beneficeE; ?> €</td>
            </tr>
            </tbody>
        </table>
        <br>
    </div>
</article>

<script>
    const ctx = document.getElementById("myChart").getContext("2d");
    const myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: [
                "Lundi",
                "Mardi",
                "Mercredi",
                "Jeudi",
                "Vendredi",
                "Samedi",
                "Dimanche",
            ],
            datasets: [
                {
                    label: "frequentation de la semaine",
                    data: [
                        <?php foreach ($frequentation as $jour => $nombreJoueurs): ?>
                        <?php echo $nombreJoueurs; ?>,
                        <?php endforeach; ?>
                    ],
                    backgroundColor: "rgba(11,59,159,0.6)",
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            width: 300,
            height: 300
        }
    });

    const pie = document.getElementById('myPieChart').getContext('2d');
    const myPieChart = new Chart(pie, {
        type: 'pie',
        data: {
            labels: ['gain du casino', 'gain des joueurs'],
            datasets: [{
                data: [<?php echo $PourcentageGainCasino ?>, <?php echo $PourcentageGainJoueur ?>],
                backgroundColor: ['#f50036', '#eeb500'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            width: 300,
            height: 300
        }
    });


    const barData = {
        labels: ['Deuxieme', 'Premier', 'Troisieme'],
        datasets: [{
            label: 'gains',
            data: [<?php echo $deuxieme[1] ?>,<?php echo $premier[1] ?>, <?php echo $troisieme[1] ?>], // Example data values
            backgroundColor: '#f50036',
        }]
    };

    const barCtx = document.getElementById('myHorizontalBarChart').getContext('2d');
    const myHorizontalBarChart = new Chart(barCtx, {
        type: 'bar',
        data: barData,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            width: 300,
            height: 300
        }
    });
</script>
</body>
</html>