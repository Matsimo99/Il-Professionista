<?php
// Inizializzazione delle variabili in modo sicuro
$professione = $_GET['professione'] ?? '';  // Impostiamo un valore vuoto se non è settato
$citta = $_GET['citta'] ?? '';  // Impostiamo un valore vuoto se non è settato
$no_results_message = false;  // Impostiamo la variabile a false inizialmente

// Parametri di connessione al database PostgreSQL di Render
$host = 'dpg-curf2orv2p9s73ahh69g-a.oregon-postgres.render.com';
$port = '5432';  // La porta di default di PostgreSQL
$dbname = 'profslq';  // Il nome del database
$user = 'profslq_user';  // Nome utente del database
$password = 'MyafAY0wufx7p2gqyiqevR7EddKmxBMu';  // La password del database

// Inizializzazione delle variabili
$valutazione_inviata = false; // Variabile per verificare se la valutazione è stata inviata
$valutazione_successo = ''; // Messaggio di successo

// Connessione al database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    echo "Errore nella connessione al database.";
    exit;
}

// Gestione dell'invio della valutazione
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rating']) && isset($_POST['professionista_id'])) {
    // Gestisci l'invio della valutazione
    $rating = $_POST['rating'];
    $professionista_id = $_POST['professionista_id'];

    // Esegui la query per inserire la valutazione nel database
    $query = "INSERT INTO valutazioni (professionista_id, valutazione) VALUES ($1, $2)";
    $result = pg_query_params($conn, $query, array($professionista_id, $rating));

    if ($result) {
        // Imposta la variabile per il messaggio di successo
        $valutazione_inviata = true;
        $valutazione_successo = "Valutazione inviata con successo!";
    } else {
        // In caso di errore
        $valutazione_inviata = true;
        $valutazione_successo = "Si è verificato un errore nell'invio della valutazione.";
    }
}

// Gestione della ricerca
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !$valutazione_inviata) {
    // Rimuovi gli spazi iniziali e finali dai valori di ricerca
    $professione = trim($_GET['professione'] ?? '');
    $citta = trim($_GET['citta'] ?? '');
    $no_results_message = false;  // Variabile per determinare se mostrare il messaggio "Non ci sono risultati"

    // Gestione della ricerca solo se non è stato inviato un commento
    if (empty($professione) && empty($citta)) {
        $errors[] = "Per favore, compila almeno uno dei campi (Professione o Città).";
    }

    // Gestione della ricerca solo se non è stato inviato un commento
if (empty($professione) && empty($citta)) {
    $errors[] = "Per favore, compila almeno uno dei campi (Professione o Città).";
}

// Verifica che la ricerca non sia troppo generica (es. una sola lettera)
if (strlen($professione) > 1 || strlen($citta) > 1) {

    // Esegui la ricerca solo se non ci sono errori
    if (empty($errors)) {
        $query = "SELECT * FROM persone WHERE 1=1";
        $params = [];

        // Se la professione è stata inserita, cerca con il pattern ILIKE
        if ($professione) {
            $query .= " AND professione ILIKE $1";
            // Aggiungi % per permettere la ricerca parziale
            $params[] = "%" . $professione . "%";
        }

        // Se la città è stata inserita, cerca con il pattern ILIKE
        if ($citta) {
            $query .= " AND citta ILIKE $" . (count($params) + 1);
            // Aggiungi % per permettere la ricerca parziale
            $params[] = "%" . $citta . "%";
        }

        // Esegui la query
        $result = pg_query_params($conn, $query, $params);
        if (!$result) {
            echo "Errore nella query: " . pg_last_error($conn);
            exit;
        }

        // Se non ci sono risultati, imposta il messaggio per la ricerca
        if (pg_num_rows($result) == 0) {
            $no_results_message = true;
        }
    }
} else {
    $errors[] = "La ricerca deve essere composta da almeno due caratteri.";
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
    <header class="navbar">
        <div class="logo">
            <img src="logo1.jpg" alt="Logo Azienda" width="150" height="150">
        </div>
        <nav>
            <ul class="navbar-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="chi_siamo.php">Chi Siamo</a></li>
                <li><a href="trattamento_dati.php">Trattamento dei Dati</a></li>
                <li><a href="lavora_con_noi.php">Lavora con noi</a></li>
            </ul>
        </nav>
    </header>

    <section class="search-section">
        <div class="search-container">
            <p class="subheading">
                Hai cercato: <strong><?php echo htmlspecialchars($professione ?: 'Tutte le professioni'); ?></strong> nella città <strong><?php echo htmlspecialchars($citta ?: 'Tutte le città'); ?></strong>
            </p>
            <form action="search.php" method="get" class="search-form">
                <div class="input-group">
                    <label for="professione">Professione:</label>
                    <input type="text" id="professione" name="professione" value="<?php echo htmlspecialchars($professione); ?>" placeholder="">
                </div>
                <div class="input-group">
                    <label for="citta">Città:</label>
                    <input type="text" id="citta" name="citta" value="<?php echo htmlspecialchars($citta); ?>" placeholder="">
                </div>
                <button type="submit" class="btn-search">Cerca</button>
            </form>
        </div>
    </section>

    <section class="results-section">
    <div class="search-results">
        <?php if ($valutazione_inviata): ?>
            <div class="success-message">
                <p><?php echo $valutazione_successo; ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($result) && pg_num_rows($result) > 0): ?>
            <?php while ($row = pg_fetch_assoc($result)): ?>
                <?php
                $professionista_id = $row['id'];
                // Query per ottenere i social media del professionista
                $query_social = "SELECT * FROM social_media WHERE id = $1";
                $result_social = pg_query_params($conn, $query_social, array($professionista_id));
                $social_media = pg_fetch_assoc($result_social);
                ?>
                <div class="result-card">
                    <div class="img-container">
                        <?php
                        $image_path = "profili/{$row['id']}.jpg";
                        if (file_exists($image_path)) {
                            echo "<img src='$image_path' alt='Immagine di {$row['nome']} {$row['cognome']}' class='img-professionista'>";
                        } else {
                            echo "<img src='profili/default.jpg' alt='Immagine di default' class='img-professionista'>";
                        }
                        ?>
                    </div>

                    <div class="details-container">
                        <h3><?php echo htmlspecialchars($row['nome']) . ' ' . htmlspecialchars($row['cognome']); ?></h3>
                        <p><strong>Professione:</strong> <?php echo htmlspecialchars($row['professione']); ?></p>
                        <p><strong>Città:</strong> <?php echo htmlspecialchars($row['citta']); ?></p>
                        <p><strong>Azienda:</strong> <?php echo htmlspecialchars($row['nome_azienda']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                        <p><strong>Telefono:</strong> <?php echo htmlspecialchars($row['recapito_telefonico']); ?></p>
                        <p><strong>Indirizzo:</strong> <?php echo htmlspecialchars($row['via']); ?></p>
                    </div>

                    <section class="search-comment-section">
                        <div class="star-rating">
                            <input type="radio" id="star1" name="rating" value="5"><label for="star1">★</label>
                            <input type="radio" id="star2" name="rating" value="4"><label for="star2">★</label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                            <input type="radio" id="star4" name="rating" value="2"><label for="star4">★</label>
                            <input type="radio" id="star5" name="rating" value="1"><label for="star5">★</label>
                        </div>

                        <button type="submit" class="btn-submit-comment">Invia Valutazione</button>
                    </section>

                    <!-- Sezione Social Media -->
                    <?php if ($social_media && ( !empty($social_media['facebook']) || !empty($social_media['instagram']) || !empty($social_media['twitter']) || !empty($social_media['linkedin']) || !empty($social_media['youtube']) )): ?>
                        <div class="social-icons">
                            <?php if (!empty($social_media['instagram'])): ?>
                                <a href="<?php echo htmlspecialchars($social_media['instagram']); ?>" target="_blank">
                                    <img src="in.webp" alt="Instagram" style="width: 30px; height: 30px;">
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($social_media['facebook'])): ?>
                                <a href="<?php echo htmlspecialchars($social_media['facebook']); ?>" target="_blank">
                                    <img src="fb.png" alt="Facebook" style="width: 30px; height: 30px;">
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($social_media['twitter'])): ?>
                                <a href="<?php echo htmlspecialchars($social_media['twitter']); ?>" target="_blank">
                                    <img src="twitter.png" alt="Twitter" style="width: 30px; height: 30px;">
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($social_media['linkedin'])): ?>
                                <a href="<?php echo htmlspecialchars($social_media['linkedin']); ?>" target="_blank">
                                    <img src="linkedin.png" alt="LinkedIn" style="width: 30px; height: 30px;">
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($social_media['youtube'])): ?>
                                <a href="<?php echo htmlspecialchars($social_media['youtube']); ?>" target="_blank">
                                    <img src="youtube.png" alt="YouTube" style="width: 30px; height: 30px;">
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <?php if ($no_results_message): ?>
                <p class="no-result">Non ci sono risultati per la tua ricerca.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
</body>
</html>





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
    document.querySelector('.search-form').addEventListener('submit', function(event) {
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