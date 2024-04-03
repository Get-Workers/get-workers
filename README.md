# Get Workers

## Setup

#### 1. Prepare `.env`
```bash
cp .env.example .env
```

#### 2. Run `composer install`
```bash
docker compose run --no-deps --entrypoint='composer install' app
```

#### 3. Generate application key
```bash
docker compose run --no-deps --entrypoint='php artisan key:generate' app
```

#### 4. Up all containers
```bash
docker compose up -d
```

#### 5. Run all fresh migrations
```bash
docker compose run --entrypoint='php artisan migrate:fresh' app
```
Or with seeds
```bash
docker compose run --entrypoint='php artisan migrate:fresh --seed' app
```

#### 6. Compile Front-end
```bash
docker compose exec app npm run dev
```

## Only up

#### 1. UP
```bash
docker compose up -d
```

#### 1. Compile Front-end
```bash
docker compose exec app npm run dev
```
