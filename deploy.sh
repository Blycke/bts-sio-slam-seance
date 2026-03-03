#!/bin/bash
# Script de déploiement simplifié pour BiblioTech
# usage: ./deploy.sh [staging|production]

ENV=${1:-production}

if [ "$ENV" = "staging" ]; then
    echo "Déploiement sur l'environnement de staging..."
    # adapter selon votre plateforme (Heroku, VPS, etc.)
    # ex: git push heroku-staging main
else
    echo "Déploiement sur l'environnement de production..."
    # ex: git push heroku main
fi

echo "Migrations et cache"
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Déploiement terminé."
