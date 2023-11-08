<?php


namespace App\emuns;


enum TypeAlert: string {
    case Warning = 'warning';
    case Success = 'success';
    case Danger = 'danger';
}