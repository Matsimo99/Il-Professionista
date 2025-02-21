<?php
// Parametri di connessione al database PostgreSQL di Render
$host = 'dpg-curf2orv2p9s73ahh69g-a.oregon-postgres.render.com';
$port = '5432';  // La porta di default di PostgreSQL
$dbname = 'profslq';  // Il nome del database
$user = 'profslq_user';  // Nome utente del database
$password = 'MyafAY0wufx7p2gqyiqevR7EddKmxBMu';  // La password del database

// Connessione al database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    echo "Errore nella connessione al database.";
    exit;
}

// Variabile per tenere traccia se è stato inviato un commento
$commento_inviato = false;
$commento_successo = '';

// Gestire l'invio dei commenti
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['commento'], $_POST['professionista_id'])) {
    $commento = $_POST['commento'];
    $professionista_id = $_POST['professionista_id'];

    if (!empty($commento)) {
        // Inserisci il commento nel database
        $insert_query = "INSERT INTO commenti (professionista_id, commento) VALUES ($1, $2)";
        $result_insert = pg_query_params($conn, $insert_query, [$professionista_id, $commento]);

        if ($result_insert) {
            $commento_inviato = true; // Commento inviato con successo
            $commento_successo = 'Il tuo commento è stato inviato con successo!';
        } else {
            echo "Errore nell'inserimento del commento: " . pg_last_error($conn);
        }
    }
}

// Variabili per la ricerca
$professione = $_GET['professione'] ?? '';
$citta = $_GET['citta'] ?? '';

// Solo eseguire la ricerca se non è stato inviato un commento
if (!$commento_inviato) {
    // Controlla se almeno uno dei campi è stato compilato
    if (empty($professione) && empty($citta)) {
        $errors[] = "Per favore, compila almeno uno dei campi (Professione o Città).";
    }

    // Se non ci sono errori, esegui la ricerca
    if (empty($errors)) {
        // Crea la query di ricerca
        $query = "SELECT * FROM persone WHERE 1=1";  // 1=1 è una condizione sempre vera, per facilitare l'aggiunta dinamica di altre condizioni
        $params = []; // Array per i parametri della query

        // Aggiungi la condizione per la professione, solo se è stata specificata
        if ($professione) {
            $query .= " AND professione ILIKE $1";
            $params[] = '%' . $professione . '%';
        }

        // Aggiungi la condizione per la città, solo se è stata specificata
        if ($citta) {
            $query .= " AND citta ILIKE $" . (count($params) + 1); // Incremente il numero del parametro
            $params[] = '%' . $citta . '%';
        }

        // Esegui la query con i parametri solo se ci sono campi compilati
        $result = pg_query_params($conn, $query, $params);
        if (!$result) {
            echo "Errore nella query: " . pg_last_error($conn);
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Risultati Ricerca Professionisti</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Barra di navigazione fissa -->
    <header class="navbar">
        <div class="logo">
            <img src="logo1.jpg" alt="Logo Azienda" width="150" height="150">
        </div>
        <nav>
            <ul class="navbar-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="chi_siamo.php">Chi Siamo</a></li>
                <li><a href="trattamento_dati.php">Trattamento dei Dati</a></li>
            </ul>
        </nav>
    </header>

    <!-- Sezione di ricerca -->
    <section class="search-section">
        <div class="search-container">
            <p class="subheading">
                Hai cercato: <strong><?php echo htmlspecialchars($professione ?: 'Tutte le professioni'); ?></strong> nella città <strong><?php echo htmlspecialchars($citta ?: 'Tutte le città'); ?></strong>
            </p>
            <form action="search.php" method="get" class="search-form">
                <div class="input-group">
                    <label for="professione">Professione:</label>
                    <input type="text" id="professione" name="professione" value="<?php echo htmlspecialchars($professione); ?>" placeholder="Es. Medico">
                </div>
                <div class="input-group">
                    <label for="citta">Città:</label>
                    <input type="text" id="citta" name="citta" value="<?php echo htmlspecialchars($citta); ?>" placeholder="Es. Roma">
                </div>
                <button type="submit" class="btn-search">Cerca</button>
            </form>
        </div>
    </section>

    <!-- Sezione per i risultati della ricerca -->
    <section class="results-section">
        <div class="search-results">
            <!-- Messaggio di commento inviato con successo -->
            <?php if ($commento_inviato): ?>
                <div class="success-message">
                    <p><?php echo $commento_successo; ?></p>
                </div>
            <?php endif; ?>

            <!-- Visualizzazione dei risultati della ricerca, se non è stato inviato un commento -->
            <?php if (!$commento_inviato): ?>
                <?php if (isset($result) && pg_num_rows($result) > 0): ?>
                    <?php while ($row = pg_fetch_assoc($result)): ?>
                        <div class="result-card">
                            <!-- Foto del professionista -->
                            <?php
                            $image_path = "profili/{$row['id']}.jpg";
                            if (file_exists($image_path)) {
                                echo "<div class='img-container'>";
                                echo "<img src='$image_path' alt='Immagine di {$row['nome']} {$row['cognome']}' class='img-professionista'>";
                                echo "</div>";
                            } else {
                                echo "<div class='img-container'>";
                                echo "<img src='profili/default.jpg' alt='Immagine di default' class='img-professionista'>";
                                echo "</div>";
                            }
                            ?>

                            <!-- Dettagli professionista -->
                            <div class="details-container">
                                <h3><?php echo htmlspecialchars($row['nome']) . ' ' . htmlspecialchars($row['cognome']); ?></h3>
                                <p><strong>Professione:</strong> <?php echo htmlspecialchars($row['professione']); ?></p>
                                <p><strong>Città:</strong> <?php echo htmlspecialchars($row['citta']); ?></p>
                                <p><strong>Azienda:</strong> <?php echo htmlspecialchars($row['nome_azienda']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                                <p><strong>Indirizzo:</strong> <?php echo htmlspecialchars($row['via']); ?></p>
                            </div>

                            <!-- Sezione per aggiungere il commento -->
                            <section class="search-comment-section">
                                <div class="search-comment-container">
                                    <form action="search.php" method="POST" class="comment-form">
                                        <input type="hidden" name="professionista_id" value="<?php echo $row['id']; ?>">

                                        <div class="input-group">
                                            <label for="commento">Scrivi il tuo commento:</label>
                                            <textarea name="commento" id="commento" placeholder="Scrivi qui..." required></textarea>
                                        </div>

                                        <!-- Bottone per inviare il commento, posizionato accanto al campo di testo -->
                                        <button type="submit" class="btn-submit-comment">Invia Commento</button>
                                    </form>
                                </div>
                            </section>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-results">
                        <p>Non ci sono risultati per la tua ricerca.</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>



    <footer>
        <div class="footer-container">
            <!-- Links principali -->
            <div class="footer-links">
                <ul>
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">Informativa Cookie</a></li>
                    <li><a href="#">Termini e Condizioni</a></li>
                    <li><a href="#">Contatti</a></li>
                    <li><a href="#">Help & Contatti</a></li>
                    <li><a href="#">Lavora con noi</a></li>
                    <li><a href="#">Diventa Professionista</a></li>
                    <li><a href="#">Domande Frequenti (FAQ)</a></li>
                </ul>
            </div>

            <div class="footer-social">
    <ul>
        <li>
            <a href="https://www.facebook.com/profile.php?id=61570141079818">
                <img src="fb.png" alt="Facebook" style="width: 30px; height: 30px;">
            </a>
        </li>
        <li>
            <a href="https://www.instagram.com/ilprofessionista2.0?igsh=d2swbGl0OWhoMXhs">
                <img src="in.webp" alt="Instagram" style="width: 30px; height: 30px;">
            </a>
        </li>
        <li>
            <a href="">
                <img src="what.png" alt="WhatsApp" style="width: 30px; height: 30px;">
            </a>
        </li>
    </ul>
</div>

            <!-- Copyright -->
            <div class="footer-bottom">
                <p>&copy; 2025 Azienda Ricerca Professionisti - Tutti i diritti riservati</p>
            </div>
        </div>
    </footer>

    <script>
    // Funzione per validare il modulo di ricerca
    document.querySelector('.search-form').addEventListener('submit', function (event) {
        const professione = document.querySelector('#professione').value.trim();
        const citta = document.querySelector('#citta').value.trim();

        // Controlla se entrambi i campi sono vuoti
        if (!professione && !citta) {
            alert('Per favore, compila almeno uno dei campi (Professione o Città).');
            event.preventDefault(); // Impedisce l'invio del modulo
        }
    });
</script>

</body>

</html>