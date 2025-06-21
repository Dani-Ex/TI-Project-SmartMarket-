import time
import requests
import RPi.GPIO as GPIO# Certifique-se de importar se estiver a usar um Raspberry Pi
from datetime import datetime

print("Prima CTRL+C para terminar")

while True:
    try:
        timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

        
        payload_AC = {
                    'nome': 'AC',
                    'valor': '1',
                    'hora': timestamp
                }
        
        payload_Porta = {
                    'nome': 'Porta',
                    'valor': '1',
                    'hora': timestamp
                }
        
        payload_Luz = {
                    'nome': 'Luz',
                    'valor': '1',
                    'hora': timestamp
                }
    
        response_Porta = requests.get('http://iot.dei.estg.ipleiria.pt/ti/ti088/api/api.php?nome=porta')
        response_luz = requests.get('http://iot.dei.estg.ipleiria.pt/ti/ti088/api/api.php?nome=luz')

        response_temperatura = requests.get('http://iot.dei.estg.ipleiria.pt/ti/ti088/TI-Project-SmartMarket-/api/files/temperatura_ambient/valor.txt')
        
        if response_temperatura.status_code == 200:
            temperatura = float(response_temperatura.text) 

            if temperatura > 20:
                payload_AC['valor'] = '1'
                print("vou ligar o AC do supermercado")
            else:
                payload_AC['valor'] = '0'
                print("vou desligar o AC do supermercado")

            r=requests.post('http://iot.dei.estg.ipleiria.pt/ti/ti088/api/api.php', data=payload_AC)
            print(r.text)

        else:
            print(f"Erro na requisição. Código de status: {response_temperatura.status_code}")
            
        if response_Porta.status_code == 200:
            ValorPorta = response_Porta.json()
            Porta_Estado = int(ValorPorta.get('valor', 0))

            if Porta_Estado == 1:
                payload_Porta['valor'] = '1'
                print("vou abrir a porta")

            else:
                payload_Porta['valor'] = '0'
                print("vou fechar a porta")
                
            r=requests.post('http://iot.dei.estg.ipleiria.pt/ti/ti088/api/api.php', data=payload_Porta)
            print(r.text)

        else:
            print(f"Erro na requisição. Código de status: {response_Porta.status_code}")
            
        if response_luz.status_code == 200:
            ValorLuz =  response_luz.json()
            Luz_Estado = int(ValorLuz.get('valor', 0))
            
            if Luz_Estado == 1:
                payload_Luz['valor'] = '1'
                print("vou ligar a luz")

            else:
                payload_Luz['valor'] = '0'
                print("vou desligar a luz")
                
            r=requests.post('http://iot.dei.estg.ipleiria.pt/ti/ti088/api/api.php', data=payload_Luz)
            print(r.text)

        else:
            print(f"Erro na requisição. Código de status: {response_luz.status_code}")

        time.sleep(5)
    
    except KeyboardInterrupt:
        print('\n O programa foi interrompido pelo utilizador.')
        break
    except Exception as e:
        print('Erro inesperado:', e)
    finally:
        GPIO.cleanup()
        print('Terminou o programa')
