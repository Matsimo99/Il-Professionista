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


    <!-- Sezione "Chi Siamo" -->
    <section class="about-section">
        <div class="data-container">
            <h1>Chi Siamo</h1>
            <p>Siamo un'azienda specializzata nella ricerca e selezione di professionisti altamente qualificati, con un focus specifico sulle esigenze locali. La nostra missione è connettere talenti e imprese, aiutando le aziende a trovare i professionisti giusti nella loro zona, per rispondere in modo efficace e tempestivo alle necessità del mercato.</p>
            <p>Con un profondo impegno nella qualità e nell'affidabilità, selezioniamo professionisti con competenze specifiche, esperienze consolidate e un forte orientamento al risultato. Grazie alla nostra conoscenza del territorio e del settore, siamo in grado di offrire soluzioni personalizzate che rispondono alle esigenze uniche di ogni cliente, ottimizzando i processi di selezione e garantendo un matching perfetto.</p>
            <p>In un mondo in continua evoluzione, crediamo nell’importanza di costruire connessioni solide e durature tra privati e aziende, contribuendo così al successo di entrambe le parti.</p>
            <p>Siamo il partner ideale per chi cerca il professionista giusto, nella zona giusta.</p>
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

            <!-- Social media -->
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

</html>