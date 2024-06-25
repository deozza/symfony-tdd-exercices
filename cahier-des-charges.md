# Une route pour créer un utilisateur

 * un endpoint accessible sur /user => done
 * en POST => done
 * uniquement en json en entrée et en sortie (done)
 * en payload : username, email, password => done
    * username soit requis => done
    * username fasse plus de 4 caractères et moins de 50
    * username soit unique dans la bdd
    * email soit requis => done
    * email soit au format email
    * email soit unique dans la bdd
    * password soit requis => done
    * password fasse plus de 4 caractères
    * password hashé dans la bdd
 * en response : id, dateCreation, dateUpdate, username, email => done
 * 201 en cas de succès, 400 en cas d'erreur de payload, 405 quand on tape pas en POST