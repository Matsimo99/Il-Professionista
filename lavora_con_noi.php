<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lavora con noi</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Barra di navigazione fissa -->
    <header class="navbar">
        <div class="logo">
            <img src="logo1.jpg" alt="Logo Azienda" width="150" height="150">
        </div>
        <nav>
            <!-- Icona hamburger per dispositivi mobili -->
            <div class="hamburger" id="hamburger-icon">
                <div></div>
                <div></div>
                <div></div>
            </div>

            <!-- Menu di navigazione -->
            <ul class="navbar-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="chi_siamo.php">Chi Siamo</a></li>
                <li><a href="trattamento_dati.php">Trattamento dei Dati</a></li>
                <li><a href="lavora_con_noi.php">Lavora con noi</a></li>
            </ul>

            <!-- Menu a tendina per dispositivi mobili -->
            <ul class="navbar-links-mobile" id="navbar-mobile">
                <li><a href="index.php">Home</a></li>
                <li><a href="chi_siamo.php">Chi Siamo</a></li>
                <li><a href="trattamento_dati.php">Trattamento dei Dati</a></li>
                <li><a href="lavora_con_noi.php">Lavora con noi</a></li>
            </ul>
        </nav>
    </header>

    <script>
        // Funzione per mostrare/nascondere il menu a tendina
        const hamburgerIcon = document.getElementById("hamburger-icon");
        const navbarMobile = document.getElementById("navbar-mobile");

        hamburgerIcon.addEventListener("click", () => {
            navbarMobile.classList.toggle("active");
        });
    </script>

    <!-- Sezione Lavora con Noi -->
    <section class="lavora-con-noi">
        <div class="lavora-container">
            <h1>Lavora con noi</h1>
            <h2>Unisciti al nostro team di professionisti</h2>
            <p>Sei una persona dinamica, appassionata e alla ricerca di nuove sfide? Se sì, Il Professionista potrebbe essere il posto giusto per te! Cerchiamo sempre talenti motivati per arricchire il nostro team. Dai un’occhiata alle posizioni aperte e invia la tua candidatura!</p>

            <h3>Posizioni Aperte</h3>
            <ul>
                <li>
                    <strong>Responsabile Marketing</strong>
                    <p>Unisciti al nostro team di marketing per aiutarci a far crescere la nostra piattaforma. Esperienza nel settore digitale e nella gestione di campagne pubblicitarie online è richiesta.</p>
                </li>
                <li>
                    <strong>Sviluppatore Web</strong>
                    <p>Sei appassionato di tecnologia e sviluppo? Entra nel nostro team di sviluppo per lavorare su una piattaforma innovativa e user-friendly.</p>
                </li>
                <li>
                    <strong>Specialista del Servizio Clienti</strong>
                    <p>Aiutaci a garantire un’esperienza eccezionale per i nostri utenti. Se sei una persona empatica e hai esperienza nel supporto clienti, questa posizione fa per te!</p>
                </li>
            </ul>

            <h3>Perché lavorare con noi?</h3>
            <p>Offriamo un ambiente di lavoro stimolante, orientato all’innovazione e alla crescita professionale. In Il Professionista, crediamo nel potenziale dei nostri dipendenti e nella loro capacità di fare la differenza. Ecco cosa offriamo:</p>
            <ul>
                <li><strong>Formazione continua</strong>: Potrai sviluppare le tue competenze e crescere professionalmente.</li>
                <li><strong>Ambiente dinamico</strong>: Un team giovane e motivato, sempre pronto ad affrontare nuove sfide.</li>
                <li><strong>Work-life balance</strong>: Offriamo un equilibrio tra lavoro e vita privata per garantirti benessere e produttività.</li>
                <li><strong>Stipendio competitivo</strong>: Valorizziamo il tuo lavoro e ti offriamo un compenso adeguato alle tue competenze.</li>
            </ul>

            <h3>Come candidarsi</h3>
            <p>Se una delle posizioni sopra ti interessa, invia il tuo CV e una lettera di presentazione a <a href="mailto:lavora@ilprofessionista.it">lavora@ilprofessionista.it</a>. Ti contatteremo per discutere le opportunità disponibili.</p>

            <h3>Ti aspettiamo!</h3>
            <p>Il nostro team è sempre alla ricerca di persone motivate e appassionate, pronte a mettersi in gioco. Se pensi di essere la persona giusta, non esitare a candidarti. Insieme possiamo fare la differenza!</p>
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
