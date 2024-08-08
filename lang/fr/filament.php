<?php

return [
    'models' => [
        'client' => 'Client',
        'invoice' => 'Facture',
        'category' => 'Catégorie',
        'company' => 'Entreprise',
        'product' => 'Produit',
        'service' => 'Service',
    ],
    'fields' => [
        'name' => 'Nom',
        'client' => [
            'name' => 'Nom',

        ],
        'logo' => 'Logo',
        'date' => 'Date',
        'invoice_number' => 'Numéro de facture',
        'subtotal' => 'Sous-total',
        'gst' => 'TPS',
        'pst' => 'TVQ',
        'total' => 'Total',
        'total_amount' => 'Montant total',
        'description' => 'Description',
        'category' => [
            'name' => 'Nom',

        ],
        'company_name' => 'Nom de l\'entreprise',
        'business_number' => 'Numéro d\'entreprise',
        'rbq' => 'RBQ',
        'gst_hst' => 'TPS',
        'remarks' => 'Remarques',
        'category_id' => 'Catégorie',
        'client_id' => 'Client',
        'price' => 'Prix',
        'address' => 'Adresse',
        'products' => 'Produits',
        'service_id' => 'Services',
        'city' => 'Ville',
        'state' => 'Province',
        'country' => 'Pays',
        'postal_code' => 'Code postal',

    ],
];
