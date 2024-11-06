<?php

function getShapeInfo($shape) {
    $shapes = [
        'szescian' => [
            'name' => 'Sześcian',
            'description' => 'Sześcian to bryła, której wszystkie ściany są kwadratami. Wzory:<br />
            objetosc:a^3 <br>
            powierchnia:6a^2<br />
            gdzie a to długość krawędzi sześcianu.',
            'image' => 'cube.png',
            'image2' =>'szescian.png'
        ],
        'Walec' => [
            'name' => 'Walec',
            'description' => 'Walec to bryła obrotowa z dwiema równoległymi podstawami.Wzory:<br />
            objetosc:1/3πr^2h<br />
            powierchnia:πr(r+l)<br />
            gdzie r to promień podstawy, a h to wysokość walca',
            'image' => 'cylinder.png',
            'image2' =>'walec.png'
        ],
        'Stozek' => [
            'name' => 'Stozek',
            'description' => 'Stożek to bryła obrotowa z okrągłą podstawą i wierzchołkiem.Wzory:<br />
            objetosc:πr^2h<br />
            powierchnia:2πr(r+h)<br />
            gdzie l to tworząca stożka, obliczana jako: √r^2+h^2',
            'image' => 'cone.png',
            'image2' =>'stozek.png'
        ]
    ];
    return $shapes[$shape];
}

function getShapeDimensions($shape) {
    $dimensions = [
        'szescian' => [['name' => 'side', 'label' => 'Bok sześcianu (a na obrazku)']],
        'Walec' => [['name' => 'radius', 'label' => 'Promień podstawy'], ['name' => 'height', 'label' => 'Wysokość']],
        'Stozek' => [['name' => 'radius', 'label' => 'Promień podstawy'], ['name' => 'height', 'label' => 'Wysokość']]
    ];
    return $dimensions[$shape];
}

function getShapeCalculations($shape, $dimensions) {
    switch ($shape) {
        case 'szescian':
            $side = $dimensions['side'];
            return [
                'surface_area' => 6 * (pow($side, 2)),
                'volume' => pow($side, 3)
            ];
        case 'Walec':
            $radius = $dimensions['radius'];
            $height = $dimensions['height'];
            return [
                'surface_area' => 2 * pi() * $radius * ($radius + $height),
                'volume' => pi() * pow($radius, 2) * $height
            ];
        case 'Stozek':
            $radius = $dimensions['radius'];
            $height = $dimensions['height'];
            $slant_height = sqrt(pow($radius, 2) + pow($height, 2));
            return [
                'surface_area' => pi() * $radius * ($radius + $slant_height),
                'volume' => (1/3) * pi() * pow($radius, 2) * $height
            ];
    }
}

function generateRandomDimensions($shape) {
    $dimensions = [];
    switch ($shape) {
        case 'szescian':
            $dimensions['side'] = rand(1, 10); 
            break;
        case 'Walec':
            $dimensions['radius'] = rand(1, 10); 
            $dimensions['height'] = rand(1, 10); 
            break;
        case 'Stozek':
            $dimensions['radius'] = rand(1, 10); 
            $dimensions['height'] = rand(1, 10); 
            break;
    }
    return $dimensions;
}
