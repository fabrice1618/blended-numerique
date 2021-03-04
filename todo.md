# TODO List

## DWWM
- Ajouter page erreur 404 et autres erreurs (500, 403, ....) Dossier maquette
* Corriger faille XSS
- Corriger injection SQL
- Chiffrer les mots de passe
- Ajouter token CSRF

## TSSR
- adapter les droits de l'utilisateur MySQL flopsecurity au strict nécessaire
- étudier la possibilité d'utiliser fail2ban, un IDS / IPS, un firewall applicatif
- essayer une solution pentest (burpsuite ou autre)
- installation d'une VM Ubuntu server 20.04 avec docker pour héberger le serveur web
- étudier les paramètres de apache et PHP pour configurer une machine de developpement
- mettre en place tous les logs nécessaires apache et PHP
- mettre en place des logs centralisés rsyslog