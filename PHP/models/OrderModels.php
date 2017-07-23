<?php


namespace models;


class OrderModels extends BaseModel
{
    const TABLE_NAME = 'orders';

    public function getAllOrdersWithUsers()
    {
        $query = '
                SELECT
                    o.id,
                    o.status,
                    o.amount,
                    o.created_at,
                    os.status_name,
                    os.css,
                    u.email
                FROM
                    `orders` o
                LEFT JOIN `orders_statuses` os ON
                    o.status = os.id
                LEFT JOIN `users` u ON
                    u.id = o.user_id
                ORDER BY
                    o.created_at
                DESC
                LIMIT 10';

        $result = $this->execute($query, [], true);

        return $result;
    }

    public function setOrderStatus($orderId, $statusId)
    {
        $query = '
            UPDATE
                `orders`
            SET
                `status` = :status_id
            WHERE
                `id` = :order_id;';

        $props = [
            'status_id' => $statusId,
            'order_id' => $orderId,
        ];

        $this->execute($query, $props);
    }
}