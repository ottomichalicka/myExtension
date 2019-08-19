<?php

return [
    'price' => [
        'manager' => [
            'name' => 'MyPrice',
            'standard' => [
                'insert' => [
                    'ansi' => '
					INSERT INTO "mshop_price" (
						"typeid", "currencyid", "domain", "label",
						"quantity", "value", "costs", "rebate","test", "taxrate",
						"status", "mtime", "editor", "siteid", "ctime"
					) VALUES (
						?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
					)
				',
                ],
                'update' => [
                    'ansi' => '
					UPDATE "mshop_price"
					SET "typeid" = ?, "currencyid" = ?, "domain" = ?, "label" = ?,
						"quantity" = ?, "value" = ?, "costs" = ?, "rebate" = ?, "test" = ?,
						"taxrate" = ?, "status" = ?, "mtime" = ?, "editor" = ?
					WHERE "siteid" = ? AND "id" = ?
				',
                ],
                'search' => [
                    'ansi' => '
					SELECT mpri."id" AS "price.id", mpri."siteid" AS "price.siteid",
						mpri."typeid" AS "price.typeid", mpri."currencyid" AS "price.currencyid",
						mpri."domain" AS "price.domain", mpri."label" AS "price.label",
						mpri."quantity" AS "price.quantity", mpri."value" AS "price.value",
						mpri."costs" AS "price.costs", mpri."rebate" AS "price.rebate",
						mpri."test" AS "price.test",
						mpri."taxrate" AS "price.taxrate", mpri."status" AS "price.status",
						mpri."mtime" AS "price.mtime", mpri."editor" AS "price.editor",
						mpri."ctime" AS "price.ctime"
					FROM "mshop_price" AS mpri
					:joins
					WHERE :cond
					GROUP BY mpri."id", mpri."siteid", mpri."typeid", mpri."currencyid",
						mpri."domain", mpri."label", mpri."quantity", mpri."value",
						mpri."costs", mpri."rebate", mpri."test", mpri."taxrate", mpri."status",
						mpri."mtime", mpri."editor", mpri."ctime" /*-columns*/ , :columns /*columns-*/
					/*-orderby*/ ORDER BY :order /*orderby-*/
					LIMIT :size OFFSET :start
				',
                ],
            ],
        ],
    ],
];