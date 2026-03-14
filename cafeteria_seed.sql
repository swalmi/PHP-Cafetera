-- Cafeteria Demo Seed Data
-- Import after creating schema from cafeteria_db.sql
-- Usage:
--   mysql -u root -p cafeteria_db < cafeteria_seed.sql
--
-- Seed login credentials:
--   Admin: admin@cafeteria.com / Admin@123
--   User : user1@cafeteria.com / User@1234
--   User : user2@cafeteria.com / User@1234
--   User : user3@cafeteria.com / User@1234
--   User : user4@cafeteria.com / User@1234

SET NAMES utf8mb4;

SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE order_items;

TRUNCATE TABLE orders;

TRUNCATE TABLE products;

TRUNCATE TABLE categories;

TRUNCATE TABLE users;

TRUNCATE TABLE rooms;

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO
    rooms (id, name)
VALUES (1, '101'),
    (2, '102'),
    (3, '103'),
    (4, '104'),
    (5, '201');

INSERT INTO
    categories (id, name)
VALUES (1, 'Hot Drinks'),
    (2, 'Cold Drinks'),
    (3, 'Desserts'),
    (4, 'Snacks');

INSERT INTO
    users (
        id,
        name,
        email,
        password,
        room_id,
        image,
        role,
        created_at
    )
VALUES (
        1,
        'System Admin',
        'admin@cafeteria.com',
        '$2y$12$NEJ2AbPYSMHP28GDlJ5pleLgIsVp/k17kQfH9AH5ilolumppjgCza',
        1,
        'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=256&q=80',
        'admin',
        '2026-03-01 08:00:00'
    ),
    (
        2,
        'Ahmed Hassan',
        'user1@cafeteria.com',
        '$2y$12$t4YVUbpGDuDnfrYWCZ/eHu1IvsVccY5jS8s31WdChM9aeJhUtiac6',
        2,
        'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=256&q=80',
        'user',
        '2026-03-01 08:15:00'
    ),
    (
        3,
        'Mona Adel',
        'user2@cafeteria.com',
        '$2y$12$t4YVUbpGDuDnfrYWCZ/eHu1IvsVccY5jS8s31WdChM9aeJhUtiac6',
        3,
        'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=256&q=80',
        'user',
        '2026-03-01 08:20:00'
    ),
    (
        4,
        'Youssef Ali',
        'user3@cafeteria.com',
        '$2y$12$t4YVUbpGDuDnfrYWCZ/eHu1IvsVccY5jS8s31WdChM9aeJhUtiac6',
        4,
        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=256&q=80',
        'user',
        '2026-03-01 08:25:00'
    ),
    (
        5,
        'Nour Emad',
        'user4@cafeteria.com',
        '$2y$12$t4YVUbpGDuDnfrYWCZ/eHu1IvsVccY5jS8s31WdChM9aeJhUtiac6',
        5,
        'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=256&q=80',
        'user',
        '2026-03-01 08:30:00'
    );

INSERT INTO
    products (
        id,
        name,
        price,
        image,
        category_id,
        created_at
    )
VALUES (
        1,
        'Espresso',
        35.00,
        'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=640&q=80',
        1,
        '2026-03-01 09:00:00'
    ),
    (
        2,
        'Cappuccino',
        45.00,
        'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=640&q=80',
        1,
        '2026-03-01 09:02:00'
    ),
    (
        3,
        'Latte',
        50.00,
        'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=640&q=80',
        1,
        '2026-03-01 09:04:00'
    ),
    (
        4,
        'Iced Coffee',
        55.00,
        'https://images.unsplash.com/photo-1517705008128-361805f42e86?auto=format&fit=crop&w=640&q=80',
        2,
        '2026-03-01 09:06:00'
    ),
    (
        5,
        'Orange Juice',
        40.00,
        'https://images.unsplash.com/photo-1600271886742-f049cd5bba3f?auto=format&fit=crop&w=640&q=80',
        2,
        '2026-03-01 09:08:00'
    ),
    (
        6,
        'Chocolate Muffin',
        30.00,
        'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?auto=format&fit=crop&w=640&q=80',
        3,
        '2026-03-01 09:10:00'
    ),
    (
        7,
        'Croissant',
        28.00,
        'https://images.unsplash.com/photo-1608198093002-ad4e005484ec?auto=format&fit=crop&w=640&q=80',
        4,
        '2026-03-01 09:12:00'
    );

INSERT INTO
    orders (
        id,
        user_id,
        room_id,
        notes,
        total_price,
        status,
        created_at
    )
VALUES (
        1,
        2,
        2,
        'No sugar please',
        103.00,
        'done',
        '2026-03-05 10:15:00'
    ),
    (
        2,
        3,
        3,
        'Extra hot',
        90.00,
        'done',
        '2026-03-06 11:20:00'
    ),
    (
        3,
        2,
        2,
        'Deliver quickly',
        93.00,
        'processing',
        '2026-03-10 09:10:00'
    ),
    (
        4,
        4,
        4,
        'Add napkins',
        85.00,
        'out_for_delivery',
        '2026-03-10 12:05:00'
    ),
    (
        5,
        5,
        5,
        'No notes',
        40.00,
        'cancelled',
        '2026-03-11 14:40:00'
    ),
    (
        6,
        3,
        3,
        'Team meeting order',
        148.00,
        'done',
        '2026-03-12 13:15:00'
    ),
    (
        7,
        4,
        4,
        'Less ice',
        55.00,
        'processing',
        '2026-03-13 10:50:00'
    ),
    (
        8,
        5,
        5,
        'Birthday treat',
        108.00,
        'done',
        '2026-03-13 16:25:00'
    );

INSERT INTO
    order_items (
        id,
        order_id,
        product_id,
        quantity,
        price
    )
VALUES (1, 1, 2, 1, 45.00),
    (2, 1, 6, 1, 30.00),
    (3, 1, 7, 1, 28.00),
    (4, 2, 3, 1, 50.00),
    (5, 2, 5, 1, 40.00),
    (6, 3, 1, 1, 35.00),
    (7, 3, 7, 1, 28.00),
    (8, 3, 6, 1, 30.00),
    (9, 4, 4, 1, 55.00),
    (10, 4, 6, 1, 30.00),
    (11, 5, 5, 1, 40.00),
    (12, 6, 2, 2, 45.00),
    (13, 6, 6, 1, 30.00),
    (14, 6, 7, 1, 28.00),
    (15, 7, 4, 1, 55.00),
    (16, 8, 3, 1, 50.00),
    (17, 8, 6, 1, 30.00),
    (18, 8, 7, 1, 28.00);

ALTER TABLE rooms AUTO_INCREMENT = 6;

ALTER TABLE categories AUTO_INCREMENT = 5;

ALTER TABLE users AUTO_INCREMENT = 6;

ALTER TABLE products AUTO_INCREMENT = 8;

ALTER TABLE orders AUTO_INCREMENT = 9;

ALTER TABLE order_items AUTO_INCREMENT = 19;