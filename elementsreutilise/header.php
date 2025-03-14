</head>
<body>
<header>
    <div class="logo">
       <a href="./"><img src="/images/logo.svg" alt="logoLogo de Delta Plus, représentant le nom de l'entreprise en lettres stylisées sur fond bleu."></a>
    </div>
    <div>
       <div class="burger">
          <img id="bouton" src="/images/burger.svg" alt="">
       </div>
       <nav id="nav">
         <ul>
            <li>
               <a href="/">Accueil</a>
            </li>
            <li>
               <a href="/pages/apropos">A propos</a>
            </li>
            <li>
               <a href="/metiers/index.php">Nos Métiers</a>
               <ul>
                  <li><a href="/metiers/accueil">Accueil</a></li>
                  <li><a href="/metiers/finance">Finance</a></li>
                  <li><a href="/metiers/rh">Ressources humaines</a></li>
                  <li><a href="/metiers/it">Informatique</a></li>
                  <li><a href="/metiers/accueil">Commerce</a></li>
                  <li><a href="/metiers/finance">Export</a></li>
                  <li><a href="/metiers/logistique">Logistique</a></li>
                  <li><a href="/metiers/marketing">Marketing</a></li>
                  <li><a href="/metiers/achats">Achats</a></li>
                  <li><a href="/metiers/produits">Produits</a></li>
                  <li><a href="/metiers/servicegene">Service généraux</a></li>
               </ul>
            </li>
            <li><a href="/offres/">Nos Offres d'emplois</a></li>
            <li><a href="/pages/nouscontacter">Nous contacter</a></li>
            <li class="cachemobile">
            <a href="https://deltaplus.optimhum.fr/">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
               </svg>
               Compte</a>
               
               <ul>
               <?php
               if (isset($_SESSION['LOGGED_USER'])){
                  if ($_SESSION['USER_ROLE'] != "admin" && $_SESSION['USER_ROLE'] != "rh") {
                     echo '<li><a href="/candidat/profil">Mon profil</a></li>';
                     echo '<li><a href="/candidat/doc">Mes documents</a></li>';
                     echo '<li><a href="/candidat/favoris">Mes annonces</a></li>';
                     echo '<li><a href="/candidat/messages">Mes messages</a></li>';
                  } else {
                     echo '<li><a href="/open">Gestion</a></li>';
                  }
                  echo '<li><a href="/loggin/logout">Déconnexion</a></li>';
               } else {
                  echo '<li><a href="/loggin/ucandidats">Connexion</a></li>';
                  echo '<li><a href="/candidat/inscription">Créer un compte</a></li>';
               }
               ?>
               </ul>
            </li>
            <?php
               if (isset($_SESSION['LOGGED_USER'])){
                  if ($_SESSION['USER_ROLE'] != "admin" && $_SESSION['USER_ROLE'] != "rh") {
                     echo '<li class="cachebureau"><a href="/candidat/profil">Mon profil</a></li>';
                     echo '<li class="cachebureau"><a href="/candidat/doc">Mes documents</a></li>';
                     echo '<li class="cachebureau"><a href="/candidat/favoris">Mes annonces</a></li>';
                     echo '<li class="cachebureau"><a href="/candidat/messages">Mes messages</a></li>';
                  } else {
                     echo '<li class="cachebureau"><a href="open">Gestion</a></li>';
                  }
                  echo '<li class="cachebureau"><a href="/loggin/logout">Déconnexion</a></li>';
               } else {
                  echo '<li class="cachebureau"><a href="/loggin/ucandidats">Connexion</a></li>';
                  echo '<li class="cachebureau"><a href="/candidat/inscription">Créer un compte</a></li>';
               }
               ?>
         </ul>
       </nav>
    </div>
</header>
   <script>
       document.getElementById("bouton").onclick = function() {ShowFunction()};
 
       function ShowFunction() {
          document.getElementById("nav").classList.toggle("show");
       }
   </script>