# Экспериментальная интеграция Spiral Cycle ORM с Wordpress

Бандл для кастомных вариантов Wordpress + Symfony.

### Установка

composer.json:

```json
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/proklung/proklung/wp.cycle.orm"
        }
    ]
```

```bash

composer require proklung/proklung/wp-cycle-orm

```

### Пример конфигурационного файла (`/config/packages/wp_cycle_orm.yaml`)

```yaml
wp_cycle_orm:
  default_connection: mysql # Соединение по умолчанию
  # Путь к папке с сущностями
  entities_path: '%kernel.project_dir%/utils/Bundles/WpCycleOrmBundle/Entities'
  databases:
    default:
      connection: mysql
      prefix: wp_

  connections:
    mysql:
      driver: Spiral\Database\Driver\MySQL\MySQLDriver
      options:
        host: '%env(DB_HOST)%'
        db_name: '%env(DB_NAME)%'
        username: '%env(DB_USER)%'
        password: '%env(DB_PASSWORD)%'
```

### Использование

```php
$orm = container()->get('cycle_orm.orm');
$data = $orm->getRepository(Post::class)->findByPK(1189);
```