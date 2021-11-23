# car-rent

# Установка
1. Клонировать репоризорий
> git clone https://github.com/ForeachGame/car-rent.git

2. В файле .env подключить базу данных в параметре DATABASE_URL
3. Выполнить
> composer install
4. Выполнить миграции
> symfony console doctrine:migrations:migrate
5. Добавить тестовые данные 
> symfony console doctrine:fixtures:load

Дефолтные доступы администратора после импорта тестовых данных

login: admin <br />
password: admin

---
Чтобы API работало без авторизации, в файле /config/packages/security.yaml перед строкой "- { path: ^/api, roles: ROLE_USER }" добавить "#"

***
# API
## User api
### Список пользователей
>/api/user/list

### Добавить пользователя
> /api/user/add

Параметры
- name*
- last_name*
- phone*
- user_group*
- middle_name

### Редактирование пользователя
> /api/user/update/{id}

Параметры
- name*
- last_name*
- phone*
- user_group*
- middle_name

### Удаление пользователя
> /api/user/delete/{id}

## Car api
### Список автомобилей
>/api/car/list

Параметры
- sort (id, title, owner, car_type)
- order (ASC, DESC)
- owner
- car_type

### Добавить автомобиль
> /api/car/add

Параметры
- title*
- car_type*
- owner*
- active

### Редактирование автомобиля
> /api/car/update/{id}

Параметры
- title*
- car_type*
- owner*
- active

### Удаление автомобиля
> /api/car/delete/{id}

## Rent api
### Список аренд
>/api/rent/list

Параметры
- sort (id, car, client, start_date, end_date)
- order (ASC, DESC)
- car
- client
- owner

### Добавить аренду
> /api/rent/add

Параметры
- car*
- client*
- start_date* (YYYY-MM-DDTH:i:s)
- end_date* (YYYY-MM-DDTH:i:s)
