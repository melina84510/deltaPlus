<div class="boutons">
    <button onclick="goBack()">Retour</button>
    <button onclick="goTop()" id="topBtn">Haut de page</button>
    <script>
         function goBack() {
               window.history.back();
         }
         function goTop() {
               window.scrollTo({ top: 0, behavior: 'smooth' });
         }
         function closePopup() {
            document.getElementById("popup").style.display = "none";
            window.location.href =  window.location.href = 'https://deltaplus.optimhum.fr/ucandidats';;
         }
    </script>

</div>
<footer>
   <div class="foot">
      <p>Nos Coordonnées</p>
      <div class="icones">
         <a href="tel:+033490439565">
         <span class="social2">z</span>
       </a>
       <a href="mailto:recrutement@deltaplus.fr">
       <span class="social2">l</span>
       </a>
      </div>
   </div>
   <div class="foot">
      <p>Nos Réseaux sociaux</p>
      <div class="icones">
         <a href="https://www.facebook.com/deltaplusgroup">
         <span class="social">F</span>
         </a>
         <a href="https://www.instagram.com/deltaplusgroup/">
         <span class="social">d</span>
         </a>
         <a href="https://www.linkedin.com/company/delta-plus">
         <span class="social">j</span>
         </a>
         <a href="https://www.youtube.com/c/DeltaPlusgroup">
         <span class="social">ù</span>
         </a>
      </div>
   </div>
   <div>
      <p><a href="/mentions">Mentions légales</a></p>
      <div></div>
   </div>
   <div>
      <p><a href="/nouscontacter">Nous Contacter</a></p>
      <div></div>
   </div>
</footer>
</body>
</html>