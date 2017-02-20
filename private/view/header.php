<!--CREATION DU HEADER-->		
	<header>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<!--Mettre le lien pour la page accueil et mettre dans img le logo cnavpl-->
					<a href="index.php"><img src="assets/img/logocnavpl.jpg" class="img-responsive"></a>
				</div>
				<div class="col-md-2">
					<!--Creation de la recherche avec animation et dans img mettre icon recherche-->
					<a href="#"><img src="assets/img/icon/recherche.png" class="img-responsive" ></a>
				</div>
				<div class="col-md-2">
					<!--Mettre le lien pour la page actualités et dans img mettre icon actualité-->
					<a href="actualite.php"><img src="assets/img/icon/actualite.png" class="img-responsive"></a>
				</div>
				<div class="container col-md-2">
					<!--Mettre le lien pour la page inscription newsletter et dans img mettre icon newsletter-->
					<button type="button" data-toggle="modal" data-target="#myModal"><a href="#" ><img src="assets/img/icon/newsletter.png" class="img-responsive" ></a></button>
							<!-- Modal -->
					<form method="GET" action="">
					  <div class="modal fade" id="myModal" role="dialog">
					    <div class="modal-dialog modal-lg">
					      <div class="modal-content">
					        <div class="modal-header">
					          <button type="button" class="close" data-dismiss="modal">&times;</button>
					          <h4 class="modal-title">Inscription à la Newsletter</h4>
					        </div>	
					        <div class="modal-body">				   
						        <div class="form-group">
						          <input type="text" name="prenom" required placeholder="Prénom">
						        </div>
						        <div class="form-group">
						          <input type="text" name="nom" required placeholder="Nom">
						        </div>
						        <div class="form-group">
						          <input type="email" name="email" required placeholder="Email">
						        </div>
						    </div>
						        <div class="modal-footer">
						          <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
						          <button type="submit" class="btn btn-default">Enregistrer</button>
					          </div>
					      </div>
					    </div>
					  </div>
					</form>
				</div>

				<div class="col-md-2">
					<!--Mettre le lien pour la page contact et dans img mettre icon contact-->
					<a href="contact.php"><img src="assets/img/icon/contact.png" class="img-responsive"></a>
				</div>
			</div>
		</div>
<!--CREATION DU MENU-->
		<nav class="navbar">
  			<div class="container">
			   <div class="row">
      			<ul class="nav navbar-nav">
					  <!--Icon accueil-->
					<li class="active">
						<a href="index.php"><img src="assets/img/icon/accueil.png" class="img-responsive"></a>
					</li>
        			<!--Qui sommes nous-->
        			<li ><a href="#">Qui sommes-nous ?</a>
                		<ul>
                		<!--<li><a href="#">Présentation de la Cnavpl</a></li>
                  			<li><a href="#">Nos missions</a></li> -->
              			</ul>
        			</li>

        			<!--La retraite des libéraux-->
        			<li><a href="#">La retraite des libéraux</a>
			          <ul>
			            <!--<li><a href="#">Définitions</a></li>
			            <li><a href="#">Le régime de base</a></li>
			            <li><a href="#">Les régimes complémentaires </a></li> --> 
			          </ul>     
			        </li>

		            <!--Chiffres clés -->
		            <li><a href="#">Chiffres clés</a>
		                <ul>
		                 <!-- <li><a href="#">Préparer sa retraite</a></li> -->
		                 <!-- <li><a href="#">Cas particuliers</a></li> -->
		                </ul>
		            </li>

		            <!--Informations pratiques -->		            
              		<li><a href="#">Informations pratiques</a>
              		</li>
                   
          		</ul>
          	</div> 
		</div>        
		</nav>
	</header>