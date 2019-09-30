create table good
(
    id          serial       not null
        constraint table_name_pk
            primary key,
    title       varchar(100) not null,
    cost        integer      not null,
    description varchar(255),
    "createdAt" timestamp default CURRENT_TIMESTAMP
);

create table order_good
(
    id       serial  not null,
    order_id integer not null
        constraint order_good_order_id_fk
            references orders,
    good_id  integer not null
        constraint order_good_good_id_fk
            references good
);

create table order_status
(
    id     serial       not null
        constraint order_status_pk
            primary key,
    status varchar(100) not null
);

alter table order_status
    owner to postgres;

INSERT INTO public.order_status (id, status) VALUES (1, 'new');
INSERT INTO public.order_status (id, status) VALUES (2, 'paid');

create table orders
(
    id     serial            not null
        constraint order_pk
            primary key,
    status integer default 1 not null
        constraint order_order_status_id_fk
            references order_status,
    amount integer default 0 not null
);
