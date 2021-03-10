# TODO List

## DWWM
- Todo:
    - Ajouter page erreur 404 et autres erreurs (500, 403, ....) Dossier maquette
    - Chiffrer les mots de passe
    - Ajouter token CSRF
- Done:
    - Corriger faille XSS
    - Corriger injection SQL

## TSSR
- Todo:
    - écrire un programme python 'brute force'
    - étudier la possibilité d'utiliser fail2ban, un IDS / IPS, un firewall applicatif
    - essayer une solution pentest (burpsuite ou autre)
    - étudier les paramètres de apache et PHP pour configurer une machine de developpement et mettre en place tous les logs nécessaires
    - mettre en place des logs centralisés rsyslog
- Done:
    - adapter les droits de l'utilisateur MySQL topsecurity au strict nécessaire
    - installation d'une VM Ubuntu server 20.04 avec docker pour héberger le serveur web