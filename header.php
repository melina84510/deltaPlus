</head>
<body>
<header>
    <div class="logo">
       <a href="./"><img src="images/logo.svg" alt="logoLogo de Delta Plus, représentant le nom de l'entreprise en lettres stylisées sur fond bleu."></a>
    </div>
    <div>
       <div class="burger">
          <img id="bouton" src="images/burger.svg" alt="">
       </div>
       <nav id="nav">
         <ul>
            <li>
               <a href="index">Accueil</a>
            </li>
            <li>
               <a href="apropos">A propos</a>
            </li>
            <li>
               <a href="metiers">Nos Métiers</a>
               <ul>
                  <li><a href="accueil">Accueil</a></li>
                  <li><a href="finance">Finance</a></li>
                  <li><a href="rh">Ressources humaines</a></li>
                  <li><a href="informatique">Informatique</a></li>
                  <li><a href="accueil">Commerce</a></li>
                  <li><a href="finance">Export</a></li>
                  <li><a href="logistique">Logistique</a></li>
                  <li><a href="marketing">Marketing</a></li>
                  <li><a href="achats">Achats</a></li>
                  <li><a href="produits">Produits</a></li>
                  <li><a href="servicegene">Service généraux</a></li>
               </ul>
            </li>
            <li><a href="offres">Nos Offres d'emplois</a></li>
            <li><a href="nouscontacter">Nous contacter</a></li>
            <li class="cachemobile">
            <a href="https://deltaplus.optimhum.fr/index">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
               </svg>
               Compte</a>
               
               <ul>
               <?php
               if (isset($_SESSION['LOGGED_USER'])){
                  echo '<li><a href="profil">Mon profil</a></li>';
                  echo '<li><a href="doc">Mes documents</a></li>';
                  echo '<li><a href="favoris">Mes annonces</a></li>';
                  echo '<li><a href="messages">Mes messages</a></li>';
                  echo '<li><a href="/logout">Déconnexion</a></li>';
               } else {
                  echo '<li><a href="ucandidats">Connexion</a></li>';
                  echo '<li><a href="inscription">Créer un compte</a></li>';
               }
               ?>
               </ul>
            </li>
            <?php
               if (isset($_SESSION['LOGGED_USER'])){
                  echo '<li class="cachebureau"><a href="profil">Mon profil</a></li>';
                  echo '<li class="cachebureau"><a href="doc">Mes documents</a></li>';
                  echo '<li class="cachebureau"><a href="favoris">Mes annonces</a></li>';
                  echo '<li class="cachebureau"><a href="messages">Mes messages</a></li>';
                  echo '<li class="cachebureau"><a href="/logout">Déconnexion</a></li>';
               } else {
                  echo '<li class="cachebureau"><a href="ucandidats">Connexion</a></li>';
                  echo '<li class="cachebureau"><a href="inscription">Créer un compte</a></li>';
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