#EJERCICIO 1

# Mediante un bucle while el usuario podra elegir hasta 3 opciones siendo la última la que lo detendra
while True:
    operacion = int(input("Escoge la forma que deseas hacer, 1-CUADRADO, 2-RECTÁNGULO o 3-Para finalizar : "))
#Mediante un bucle for se imprimirá la forma deseada
    if operacion == 1:
        basecu = int(input("Escoge el lado de tu cuadrado:  "))
        for i in range(basecu):
            print(basecu *'*')
#Crearemos las variables
        areacu = basecu * basecu
        print("El Área de tu cuadrado es = ", areacu)
        perimetro1 = basecu * 4
        print("El Perímetro de tu cuadrado es = ", perimetro1)
#En el rectángulo las bases deben ser distaintas
    elif operacion == 2:
        base_rectangulo = int(input("Elige la base de tu rectángulo: "))
        altura_rectangulo = int(input("Ahora, escoge la altura de tu rectángulo: "))
        if base_rectangulo == altura_rectangulo:
            print("Error, tienen la misma base")
        elif base_rectangulo != altura_rectangulo:
#Ahora en el bucle for escogemos la altura 
            for i in range(altura_rectangulo):
                print(base_rectangulo*'*')
            area = base_rectangulo * altura_rectangulo
            print("El Área de tu rectángulo es =", area )
            perimetro2 = (base_rectangulo*2) + (altura_rectangulo*2)
            print("El Perímetro de tu rectángulo es =", perimetro2)
#Si el usuario pulsa 3 se terminara el bucle gracaias al break
    elif operacion == 3:
        print("Final del programa")
        break
    else:
        print("Opción no disponible, selecciona una correcta: 1-Cuadrado, 2-Rectángulo o 3-Para finalizar el programa")


#EJERCICIO 2-----------------------



#El import random sera para que la maquina elija


import random

print("Juguemos a piedra, papel o tijera")

# Aqui tenemos los resultados para el juego
# 1 = Piedra
# 2 = Papel
# 3 = Tijeras
# Crearemos contadores para saber el resultado de la ronda

conta_usuario = 0
conta_programa = 0
#El bucle solo permitira ganar 3 rondas y finalizará el juego

while conta_programa!=3 and conta_usuario !=3:

     
 #Para la eleccion aleatoria necesitamos un .randint que escogera entre 1 y 3

    eleccion1 = int(input("Selecciona '1' para piedra, '2' para Papel o '3' para Tijera: "))
    eleccionrandom = random.randint(1,3)


    if eleccion1 == 1 and eleccionrandom == 1:
        print("Tu selección es piedra")
        print("El programa ha seleccionado Piedra, Empate")
        conta_usuario = conta_usuario + 0
        conta_programa = conta_programa + 0

#De esta forma imprimira el resultado para cada ronda
        print("La máquina tiene",conta_programa, "rondas ganadas")
        print("Tienes", conta_usuario, "rondas ganadas")


    if eleccion1 == 1 and eleccionrandom == 2:
        print("Tu selección es piedra")
        print("El programa ha seleccionado Papel, has perdido")
        conta_usuario = conta_usuario + 0
        conta_programa = conta_programa + 1
        print("La máquina tiene",conta_programa, "rondas ganadas")
        print("Tienes", conta_usuario, "rondas ganadas")


    if eleccion1 == 1 and eleccionrandom == 3:
        print("Tu selección es piedra")
        print("El programa ha seleccionado Tijeras, has Ganado")
        conta_usuario = conta_usuario + 1
        conta_programa = conta_programa + 0
        print("\nLa máquina tiene",conta_programa, "rondas ganadas")
        print("Tienes", conta_usuario, "rondas ganadas")


    if eleccion1 == 2 and eleccionrandom == 2:
        print("Tu selección es papel")
        print("El programa ha seleccionado Papel, Empate")
        conta_usuario = conta_usuario + 0
        conta_programa = conta_programa + 0
        print("La máquina tiene",conta_programa, "rondas ganadas")
        print("Tienes", conta_usuario, "rondas ganadas")


    if eleccion1 == 3 and eleccionrandom == 3:
        print("Tu selección es tijeras")
        print("El programa ha seleccionado Tijera, Empate")
        conta_usuario = conta_usuario + 0
        conta_programa = conta_programa + 0
        print("La máquina tiene",conta_programa, "rondas ganadas")
        print("Tienes", conta_usuario, "rondas ganadas")

        
    if eleccion1 == 2 and eleccionrandom == 1:
        print("Has elegido papel")
        print("El programa ha elegido Piedra, has ganado")
        conta_usuario = conta_usuario + 1
        print("La máquina tiene",conta_programa, "rondas ganadas")
        print("Tienes", conta_usuario, "rondas ganadas")

    if eleccion1 == 2 and eleccionrandom == 3:
        print("Has elegido papel")
        print("El programa ha elegido tijeras, has perdido")
        conta_programa = conta_programa + 1
        print("La máquina tiene",conta_programa, "rondas ganadas")
        print("Tienes", conta_usuario, "rondas ganadas")

    if eleccion1 == 3 and eleccionrandom == 1:
        print("Has elegido tijeras")
        print("El programa ha elegido Piedra, has perdido")
        conta_programa = conta_programa + 1
        print("La máquina tiene",conta_programa, "rondas ganadas")
        print("Tienes", conta_usuario, "rondas ganadas")

    if eleccion1 == 3 and eleccionrandom == 2:
        print("Has elegido tijeras")
        print("El programa ha elegido Papel, has ganado")
        conta_usuario = conta_usuario + 1
        print("La máquina tiene",conta_programa, "rondas ganadas")
        print("Tienes", conta_usuario, "rondas ganadas")



#Ponemos una condición para que el número elegido solo pueda ser entre el 1 y el 3
    if eleccion1 >3 or eleccion1 <0:
        print("Escoge un número del 1 al 3")
#Una vez finalizado el programa tendremos un mensaje de texto para saber si hemos ganado o hemos perdido
if conta_programa == 3:
     print("El programa ha llegado a 3 rondas ganadas")
     print("Has perdido, más suerte la próxima vez")
elif conta_usuario == 3:
     print("Tienes 3 rondas ganadas")
     print("WOW, eres el campeón")
  



#EJERCICIO 3-----------------------
print("Accediendo a tu banco")
while True:
    
#El saldo debera ser positivo al empezar para que el programa funcione, el usuario debera introducir un número mayor que 0
    saldoinicio = float(input("Introduce el saldo de tu cuenta para poder tener un registro: "))
    if saldoinicio < 0:
        print("Introduce un saldo positivo")
    elif saldoinicio > 0:
        break


#Contadores para los ingresos y retiradas
containgresos = 0
contaretiradas = 0
#Una vez obtenido el saldo inicial, se iniciará el menú del banco
while True:
 
    menuban = int(input("Selecciona una de las opciones: 1-Ingresar dinero, 2-Retirar dinero, 3-Mostrar saldo disponible,  4-Salir o 5-Para ver los ingresos y las retiradas de dinero efectuadas: "))
    if menuban ==1:
        ingresodinero = float(input("Introduce el dinero que quieras ingresar: "))


#Gracias a saldoinicio tendremos los ingresos y retiradas en tiempo real
        saldoinicio = saldoinicio + ingresodinero
        containgresos = containgresos + 1
        ingresoshechos = print("Tu ingreso ha sido de ",ingresodinero,"€")
    elif menuban ==2:
        if saldoinicio >0:
            retirardinero = float(input("Cantidad a retirar: "))
            saldoinicio = saldoinicio - retirardinero


#Aqui restamos la cantidad que pida el usuario
            contaretiradas = contaretiradas + 1
            retiradashechas = print("La retirada de dinero ha sido", retirardinero,"€")


#Si el usuario tiene menos de 0 €, no podrá sacar dinero
        elif saldoinicio <= 0:
                print("En este momento no puedes sacar más dinero")
    elif menuban ==3:


#Mostraremos el saldo
        print("Tu saldo actual es", saldoinicio,"€")
    elif menuban == 4:


#Fin
        print("Nos vemos pronto")
        break


#Gracias a los contadores vemos los movimientos reaalizados
    elif menuban == 5 and contaretiradas > 0:
        print("Has retirado dinero",contaretiradas, "veces.")
        print(ingresoshechos)
    elif menuban == 5 and containgresos > 0:
        print("Has ingresado dinero",containgresos, "veces.")
        print(retiradashechas)
    elif menuban == 5 and containgresos == 0 and contaretiradas == 0:
        print("No has realizado ningún ingreso o retirada.")
    else:
        print("Opción no válida, selecciona otra opción ")

