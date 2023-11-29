<?php

namespace App\emuns;

enum PaperTypes: string {
    case A4 = 'A4';
    case Letter = 'letter';
}

enum OrientationTypes: string {
    case Portrait = 'portrait';
    case Landscape = 'landscape';
}