### Year trivia game

> Built using Laravel, Vue 3, Typescript and Tailwind

Laravel serves as a REST API that has as single endpoint. That endpoint returns a response which is fetched from the frontend. 
Most of the game logic is done on the client side, backend just returns the used data.

## Commands

```bash
# run backend app
cd backend
composer install
npm i
cp .env.example .env
php artisan serve

# run frontend
cd frontend
npm i
npm run dev
```

## Notes

Haven't spent a lot of time with PHP/Laravel (less than 20h total), so there are most probably a lot of things that can be improved.
