# TEST

Ceci est le repository pour le test technique de Farmitoo.
Celui-ci est en 3 étapes consécutives.

## 1/ Faire fonctionner les Tests  
Implémenter les méthodes pour que les tests fonctionnent.

## 2/ Afficher la page panier
Afficher le panier en twig tel que vous l'imagineriez pour une commande.
Seule l'UX sera regardée, des compétences développées en front n'étant pas requises pour le poste (donc une mise en tableau, une utilisation d'un bootstrap, etc suffiront).

## 3/ Ajouter une gestion de Promotion
Simulation de cas concret : L'équipe business veut pouvoir gérer des promotions, voici l'US à traiter: 

"En tant qu'utilisateur,
Si j'ajoute un produit dans ma commande et si une promotion est applicable, alors sa réduction s'applique sur ma commande. Je peux retrouver la réduction appliquée sur ma page panier.

Seule la première promotion applicable sur ma commande (par ordre de création) sera appliquée.

Les conditions d'application possibles sont :
- des dates de validités de la promotion
- un montant minimum de commande 
- un nombre de produit minimum dans la commande.

Une promotion pourra posséder 1 ou plusieurs de ces conditions. Si plusieurs conditions sont configurées sur la promotion, alors la condition d'application de la promotion nécessite la validation de l'ensemble de ses conditions.
"

*NB: Ajouter sur la page panier là où ça vous semble pertinent. Vous trouverez 2 promotions "en cours" dans le Controller à appliquer (ou non)*


# L'évaluation
Au niveau global, sera évalué :
- la qualité du code
- la rigueur
- les choix de conception pour la Promotion
- l'UX

## Guide de réflexion
Prenez ce projet comme si c'était le **votre** projet: si une évolution du code déjà écrit vous semble nécessaire, vous pouvez le modifier à votre guise
(et on ne dit pas par là que c'est nécessaire)

N'hésitez pas à ajouter des commentaires dans le README pour expliquer ces choix


# Annexe


#### Info TVA
Le business modèle de Farmitoo implique des règles de calculs de la TVA complexes.
Dans notre cas, il est simplifié et le taux de TVA dépend seulement de la marque du produit :
- Farmitoo => 20%
- Gallagher => 10%

#### Info frais de port
Les partenaires de Farmitoo ont des règles de calculs de frais de port très différentes. 
Voici celles de notre cas :
- Farmitoo : 12€ quelque soit le nombre de produits
- Gallagher : 14€ par tranche de 2 produits (ex: 14€ pour 1 ou 2 produits et 28€ pour 3 produits)

# Résultats

* **1er test**

Le lancement des test techniques fonctionne, pour ça j'ai créé un controller pour calculer le prix des produits (PriceCalculator),

ce controller est appelé lors de l'ajout de produit dans la commande via OrderUpdater

* **2eme test**

J'ai choisi de mettre en place un panier classique avec l'aide de Bootstrap.

Il se compose de deux parties, celle de gauche est un récapitulatif des produits ajoutés au panier avec nom du produit, marque, addition ou diminution du nombre d'éléments de chaque produits ainsi que le prix hors taxe et la suppression du produit.
S'ajoute une phrase en dessous, en cas d'eventuelle réduction ou promotion.

Pour la partie de droite, le résumé de la commande, j'ai choisi un jaune-orangé pour le coté confiance, chaleureux et c'est une couleur qui match bien avec les produits techs et l'agriculture. Ce résumé contient le nombre d'articles, les eventuels frais de port, la possibilité d'ajouter un code de réduction, un récap des sommes en jeux et un bouton commander. Le but étant d'être le plus clair possible et que le client se dirige le plus naturellement possible dans le tunnel de paiement. Avoir un maximum d'informations sans gênes visuelles afin de permettre un clic sur commander le plus simple possible.

* **3eme test**

Pour la mise en place des promotions,  j'ai choisi de créer un controller SalesCalculator, sur le modèle des frais de port et du calcul de la tva. Le but étant de passer par ce calculateur après l'ajout des produits dans la commande afin de vérifier si une promotion s'applique.

Les promotions sont ajoutées dans la commande (order) grâce au controller PromoUpdater, stockées dans un tableau et sont classées par ordre de priorité. La première dans le tableau est analysée, si elle est effective, les autres promotions ne sont pas passées en revue. En revanche, si elle ne s'applique pas, on passe à la promotion suivante, etc..

J'ai implémenté de nouvelles propriétés :

A l'entité **Order** afin d'accueillir le tableau des promotions, ainsi qu'une paire de getter/setter

A l'entité **Promotion** afin de créer un objet pertinent de ce type :
* `new Promotion('01 august 2021', '01 september 2021', 200, 0, 1200);`
* `new Promotion('', '', 0, 0, 0);`

    * Le premier paramètre est la date de début de la promotion *(qui peut etre laissé vide si pas de début)*
    * Le second paramètre est la date de fin de promotion *(qui peut etre laissé vide si c'est une promotion qui fonctionne en permanence)*
    * Le 3ème paramètre est le montant minimum d'achat pour que la promotion se declenche *(peut-être laissé à 0 si la promotion ne prend pas compte ce paramètre)*
    * Le 4ème paramètre est le nombre minimum de d'articles présent dans la commande pour que la promotion se déclenche *(peut-être laissé à 0 si la promotion ne prend pas compte ce paramètre)*
    * Le 5ème paramètre est le montant de la réduction (e.g. 1000 pour 10€) *(peut-être laissé à 0 si la promotion ne sert à rien, parce que 0€ de promo c'est pas hyper utile, enfin bon c'est possible)*

On vérifie ensuite que ces conditions sont valides avant d'appliquer la promotion, puis de l'afficher dans le panier.

J'ai également ajouté un test afin de verifier que la promotion est valide.

