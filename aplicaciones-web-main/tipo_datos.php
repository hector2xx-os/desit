<?php

    include("funciones.php");


    print("Numeros Enteros");
    print("<hr>");
    print("<br>");
    $a = 1234;
    print("valor entero:= " . $a);
    print("<br>");
    $a = -1234;
    print("valor entero negativo:= " . $a);
    print("<br>");
    $a = 0123;
    print("valor octal:= " . $a);
    print("<br>");
    $a = 0x12;
    print("valor hexadecimal:= " . $a);
    print("<br>");
    print("Numeros con punto decimal");
    print("<hr>");
    $a = 5.235234234234234234234234234234;
    print("valor con punto decimal positivo:= " . $a);
    print("<br>");
    $a = -5.235234234234234234234234234234;
    print("valor con punto decimal negativo:= " . $a);
    print("<br>");
    $a = 5.2e4;
    print("valor con punto decimal exponencial:= " . $a);
    print("<br>");
    print("<hr>");
    print("Cadenas");
    print("<br>");
    $a = "Juan";
    print("valor de la variable a es := " . $a);
    print("<br>");
    print("valor de la variable a es := $a");
    print("<br>");
    print('valor de la variable a es := $a');
    print("<hr>");
    print("Constantes");
    print("<br>");
    define("PI", 3.141516);
    print("<br>");
    print("valor de la constante PI es := " . PI);
    print("<hr>");
    print("Peradores Matematicos");
    print("<br>");
    print("suma");
    print("<br>");
    $a = 10;
    $b = 15;
    
    $c = $a + $b;

    print("<br>");
    print("La suma de $a con $b es := $c");

    $c = $a - $b;

    print("<br>");
    print("La resta de $a con $b es := $c");

    $c = $a * $b;

    print("<br>");
    print("La multiplicacion de $a con $b es := $c");

    $c = $a / $b;

    print("<br>");
    print("La division de $a con $b es := $c");

    $c = $a % $b;

    print("<br>");
    print("La modulo de $a con $b es := $c");

    $b= 0;
    
    if($b == 0)
    {
        print("<br>");
        print("Error por division en 0"); 
    }
    else
    {
        $c = $a / 0;
        print("<br>");
        print("La division de $a con 0 es := $c");
    }   
    print("<hr>");
    print("Asignaciones");
    print("<br>");
    
    $a = 5;

    print("<br>");
    print("La asignacion simple de la variable a es := $a");

    $a = 5;
    $b = 10;

    $a = $b;

    print("<br>");
    print("La asignacion de variables de la variable a es := $a");

    $a = 5;
    $b = 10;
    $c = 20;

    $a = ($b = ($c + 3));

    print("<br>");
    print("El valor de la variable a es $a, variable b es $b y variable c es $c");

    $a = 5;

    $a .= 5;

    print("<br>");
    print("El valor de la variable a es $a");
    print("<hr>");
    print("Sentencia IF");
    print("<br>");

    $a = 10;
    $b = 10;

    print("IF simple");
    print("<br>");

    if($a < $b) print("La variable a ($a) es menor que la variable b ($b) <br>");

    print("IF Else");
    print("<br>");

    if($a > $b)
    {
        print("La variable a ($a) es mayor que la variable b ($b) <br>");
    }
    else
    {
        print("La variable a ($a) es menor que la variable b ($b) <br>");
    }

    print("IF compuesto");
    print("<br>");

    if ($a < $b)
    {
        print("La variable a ($a) es menor que la variable b ($b) <br>");
    }
    elseif($a > $b)
    {
     
    print("La variable a ($a) es mayor que la variable b ($b) <br>");
    }
    else
    {
        print("Las variables son iguales ($a) ($b) <br>");
    }

    print("<hr>");
    print("Sentencia While");
    print("<br>");

    $i = 0;
    $c = 1;

    while($c <= 10)
    {
        print(($i + $c) ."<br>");
        $c++;
    }

    print("<hr>");
    print("Sentencia Do While");
    print("<br>");

    $c = 1;

    do
    {
        print("$c <br>");
        $c++;
    } while($c <= 10);

    print("<hr>");
    print("Sentencia For");
    print("<br>");

    for($i = 1; $i <= 10; $i++)
    {
        print("$i <br>");
    }

    print("<hr>");
    print("Sentencia Switch");
    print("<br>");

    $op = '*';

    switch($op)
    {
        case '+':
            print("Operacion Suma <br>");
            break;
        case '-';
            print("Operacion Resta <br>");
            break;
        default:
            print("La operacion no existe <br>");
            break;
    }

    print("<hr>");
    print("Funciones");
    print("<br>");

    function funcion1()
    {
        $a = "Esta es una funcion sin parametros";
        return $a;
    }

    $c = funcion1();
    
    print("$c <br>");

    $c = suma(5,3);
    print("La suma de 5 + 3 es $c <br>");

     $c = resta(5,10);
    print("La resta de 5 - 10 es $c <br>");
















    print("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");



?>