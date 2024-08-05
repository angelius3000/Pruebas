<?php

function FechasTextoCompleto($FechaDeMysql) // Función para convertir la fecha MYSQL a Fecha Textual

{

    $day = date("l", strtotime($FechaDeMysql));

    $daynum = date("j", strtotime($FechaDeMysql));

    $month = date("F", strtotime($FechaDeMysql));

    $year = date("Y", strtotime($FechaDeMysql));


    switch ($day) {

        case "Monday":
            $day = "Lunes";
            break;

        case "Tuesday":
            $day = "Martes";
            break;

        case "Wednesday":
            $day = "Mi&eacute;rcoles";
            break;

        case "Thursday":
            $day = "Jueves";
            break;

        case "Friday":
            $day = "Viernes";
            break;

        case "Saturday":
            $day = "S&aacute;bado";
            break;

        case "Sunday":
            $day = "Domingo";
            break;

        default:
            $day = "";
            break;
    }



    switch ($month) {

        case "January":
            $month = "Enero";
            break;

        case "February":
            $month = "Febrero";
            break;

        case "March":
            $month = "Marzo";
            break;

        case "April":
            $month = "Abril";
            break;

        case "May":
            $month = "Mayo";
            break;

        case "June":
            $month = "Junio";
            break;

        case "July":
            $month = "Julio";
            break;

        case "August":
            $month = "Agosto";
            break;

        case "September":
            $month = "Septiembre";
            break;

        case "October":
            $month = "Octubre";
            break;

        case "November":
            $month = "Noviembre";
            break;

        case "December":
            $month = "Diciembre";
            break;

        default:
            $month = "";
            break;
    }

    if ($FechaDeMysql) {

        return $day . ', ' . $daynum . " de " . $month . ", " . $year;
    } else {

        return "Sin Fecha";
    }
}

function FechasTextoCalendario($FechaDeMysql) // Función para convertir la fecha MYSQL a Fecha Textual

{

    $day = date("l", strtotime($FechaDeMysql));

    $daynum = date("j", strtotime($FechaDeMysql));

    $month = date("F", strtotime($FechaDeMysql));

    $year = date("Y", strtotime($FechaDeMysql));



    switch ($day) {

        case "Monday":
            $day = "Lunes";
            break;

        case "Tuesday":
            $day = "Martes";
            break;

        case "Wednesday":
            $day = "Mi&eacute;rcoles";
            break;

        case "Thursday":
            $day = "Jueves";
            break;

        case "Friday":
            $day = "Viernes";
            break;

        case "Saturday":
            $day = "S&aacute;bado";
            break;

        case "Sunday":
            $day = "Domingo";
            break;

        default:
            $day = "";
            break;
    }



    switch ($month) {

        case "January":
            $month = "Enero";
            break;

        case "February":
            $month = "Febrero";
            break;

        case "March":
            $month = "Marzo";
            break;

        case "April":
            $month = "Abril";
            break;

        case "May":
            $month = "Mayo";
            break;

        case "June":
            $month = "Junio";
            break;

        case "July":
            $month = "Julio";
            break;

        case "August":
            $month = "Agosto";
            break;

        case "September":
            $month = "Septiembre";
            break;

        case "October":
            $month = "Octubre";
            break;

        case "November":
            $month = "Noviembre";
            break;

        case "December":
            $month = "Diciembre";
            break;

        default:
            $month = "";
            break;
    }

    if ($FechaDeMysql) {

        return $daynum . " de " . $month . ", " . $year;
    } else {

        return "Sin Fecha";
    }
}

function SoloFecha($FechaDeMysql) // Función para convertir la fecha MYSQL a Fecha Textual

{

    $day = date("l", strtotime($FechaDeMysql));

    $daynum = date("j", strtotime($FechaDeMysql));

    $month = date("m", strtotime($FechaDeMysql));

    $year = date("Y", strtotime($FechaDeMysql));



    return $daynum . "/" . $month . "/" . $year;
}
