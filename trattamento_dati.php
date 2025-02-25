<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trattamento dei Dati</title>
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
                <li><a href="lavora_con_noi.php">Lavora con noi</a></li>
            </ul>
            <div class="menu-toggle" onclick="toggleMenu()">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>
    <script>
        function toggleMenu() {
            const menu = document.querySelector('.navbar-links');
            menu.classList.toggle('active');
        }
    </script>

    <!-- Sezione Trattamento dei Dati -->
    <section class="data-treatment-section">
        <div class="data-container">
            <h1>Trattamento dei Dati</h1>
            <h2>La protezione dei tuoi dati su Il Professionista</h2>
            <p>Su Il Professionista, la sicurezza e la privacy dei tuoi dati sono la nostra priorità. Quando cerchi un professionista, ci impegniamo a garantire che tutte le tue informazioni siano trattate con la massima riservatezza, nel pieno rispetto della normativa GDPR.</p>

            <h3>Cosa facciamo con i tuoi dati?</h3>
            <p><strong>Non vendiamo né condividiamo i tuoi dati con terzi</strong><br>I tuoi dati sono solo per uso interno e vengono utilizzati esclusivamente per migliorare la tua esperienza di ricerca e per permetterti di entrare in contatto con i professionisti che meglio rispondono alle tue esigenze.</p>
            <p><strong>Nessuna comunicazione di marketing indesiderata</strong><br>Non invieremo mai comunicazioni promozionali non richieste. Potrai scegliere di ricevere solo quelle informazioni che desideri, e potrai sempre disiscriverti da qualsiasi lista di invio in qualsiasi momento.</p>
            <p><strong>I tuoi dati sono sempre protetti</strong><br>Utilizziamo i più avanzati sistemi di protezione, con crittografia a 256 bit per proteggere le tue informazioni da accessi non autorizzati. I tuoi dati sono custoditi in sicurezza tramite Amazon Web Services, per garantirti sempre backup continui e protezione da eventuali attacchi informatici.</p>

            <h3>Perché puoi fidarti di noi?</h3>
            <p><strong>Protezione totale secondo il GDPR</strong><br>Il Professionista rispetta pienamente le normative GDPR, assicurando che tutti i dati vengano trattati con la massima attenzione e nel pieno rispetto della legge. La trasparenza è una delle nostre priorità, perciò ti spieghiamo chiaramente come vengono utilizzati i tuoi dati.</p>
            <p><strong>Controllo totale dei tuoi dati</strong><br>Sei tu l'unico proprietario dei tuoi dati. Solo tu decidi quali informazioni condividere con i professionisti che contatti tramite il nostro portale. Nessun altro avrà accesso ai tuoi dati senza il tuo consenso esplicito.</p>
            <p><strong>Facilità di accesso, ovunque ti trovi</strong><br>Grazie al cloud sicuro di Amazon Web Services, potrai accedere ai tuoi dati e alle tue informazioni da qualsiasi luogo e dispositivo, senza mai perdere la sicurezza e la protezione delle tue informazioni personali.</p>

            <h3>Sicurezza per i professionisti e i pazienti</h3>
            <p>Se sei un professionista registrato su Il Professionista, puoi essere certo che le informazioni dei tuoi pazienti sono al sicuro. La nostra piattaforma è progettata per garantire che solo tu e i tuoi assistenti possiate accedere ai dati, e sempre in modo protetto e conforme al GDPR.</p>

            <h3>Hai dubbi o necessiti di supporto?</h3>
            <p>Se hai domande sul trattamento dei tuoi dati o hai bisogno di assistenza, non esitare a contattarci all'indirizzo <a href="mailto:supporto@ilprofessionista.it">supporto@ilprofessionista.it</a>. Siamo sempre disponibili a darti una mano e a garantirti la massima trasparenza.</p>
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

</body>

</html>