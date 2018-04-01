# JukeBox Moderne

##Chemins API

POST : Créer un jukebox
Path/jukebox
Données : nameJukebox, administratorJukebox, descriptionJukebox, 
http://s07-gestion-appel-offre.zenserv.fr/index.php/jukebox

GET : Récupérer les informations d'un JukeBox : 
Path/jukebox/{tokenJukebox}
http://s07-gestion-appel-offre.zenserv.fr/index.php/jukebox/mynithluna

GET : Récupérer les playlists d'un Jukebox : 
Path/jukebox/{tokenJukebox}/queues
http://s07-gestion-appel-offre.zenserv.fr/index.php/jukebox/mynithluna/queues

GET : Récupérer les musiques de la playlist active d'un jukebox donné : 
Path/jukebox/{tokenJukebox}/queue/tracks
http://s07-gestion-appel-offre.zenserv.fr/index.php/jukebox/mynithluna/queue/tracks

POST : Ajouter une musique du catalogue dans la bibliotheque 
Path/jukebox/library/track
Données : idJukebox, idTrack
http://s07-gestion-appel-offre.zenserv.fr/index.php/jukebox/library/track

POST : Ajouter une musique de la bibliotheque dans une file 
Path/jukebox/queue/track
Données : idQueue, idTrack, userTrack
http://s07-gestion-appel-offre.zenserv.fr/index.php/jukebox/queue/track

##Contributeurs : 

Nacera Elias -
Thibaud Grepin -
Nicolas Jacquemin -
Myriam Matmat -
Lucas Marquant 