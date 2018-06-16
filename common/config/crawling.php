<?php

return [
    'json_settings' => [
        'icobazaar' => [
            'website_path' => '[0].document.details.links.website',
            'name_path' => '[0].document.description.items[0].heading',
            'description_path' => '[0].document.description.items[0].text',
            'url_placeholder_path' => '[0].link',
            'url_pattern' => 'https://icobazaar.com/{URL}',
            'url_path' => null,
            'logo_path' => '[0].document.details.picture',
            'fields_paths' => [
                'whitepaper' => '[0].document.details.whitepaper',
                'bitcointalk' => '[0].document.details.links.bitcointalk',
                'github' => '[0].document.details.links.github',
                'team' => '[0].document.team.items',
                'links_top_management' => '[0].document.team.items.1.links.linkedin',
                'amount_collected_1mln' => '[0].raised_total',
                'medium' => '[0].document.details.links.medium',
                'reddit' => '[0].document.details.links.reddit',
                'twitter' => '[0].document.details.links.twitter',
                'facebook' => '[0].document.details.links.facebook',
                'telegram' => '[0].document.details.links.telegram',
                'instagram' => '[0].document.details.links.instagram',
                'linkedin' => '[0].document.details.links.linkedin',
                'youtube' => '[0].document.details.links.youtube',
                'slack' => '[0].document.details.links.slack',
            ]
        ],
    ]
];
