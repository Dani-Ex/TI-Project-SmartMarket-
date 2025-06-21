import time
import requests
import RPi.GPIO as GPIO# Certifique-se de importar se estiver a usar um Raspberry Pi
from datetime import datetime

print("Prima CTRL+C para terminar")

while True:
    try:
        timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

        
        payload_ACAmbiente = {
                    'nome': 'ac_ambiente',
                    'valor': '1',
                    'hora': timestamp
                }
        
        payload_ACArca = {
                    'nome': 'ac_arca',
                    'valor': '1',
                    'hora': timestamp
                }
        
        payload_Porta = {
                    'nome': 'porta',
                    'valor': '1',
                    'hora': timestamp
                }
        payload_Portao = {
                    'nome': 'portao',
                    'valor': '1',
                    'hora': timestamp
                }
        
        payload_Desumidificador = {
                    'nome': 'desumidificador',
                    'valor': '1',
                    'hora': timestamp
                }
        
        payload_Luz = {
                    'nome': 'luz',
                    'valor': '1',
                    'hora': timestamp
                }
    
        response_Porta = requests.get('http://iot.dei.estg.ipleiria.pt/ti/ti088/api/api.php?nome=porta')
        response_luz = requests.get('http://iot.dei.estg.ipleiria.pt/ti/ti088/api/api.php?nome=luz')
        response_Portao = requests.get('http://iot.dei.estg.ipleiria.pt/ti/ti088/api/api.php?nome=portao')

        response_temperaturaAmbiente = requests.get('http://iot.dei.estg.ipleiria.pt/ti/ti088/TI-Project-SmartMarket-/api/files/temperatura_ambiente/valor.txt')
        response_temperaturaArca = requests.get('http://iot.dei.estg.ipleiria.pt/ti/ti088/TI-Project-SmartMarket-/api/files/temperatura_arca/valor.txt')
        response_humidade = requests.get('http://iot.dei.estg.ipleiria.pt/ti/ti088/TI-Project-SmartMarket-/api/files/humidade/valor.txt')
        
        if response_temperaturaAmbiente.status_code == 200:
            temperaturaAmbiente = float(response_temperaturaAmbiente.text) 

            if temperaturaAmbiente > 20:
                payload_ACAmbiente['valor'] = '1'
                print("vou ligar o AC do supermercado")
            else:
                payload_ACAmbiente['valor'] = '0'
                print("vou desligar o AC do supermercado")

            r=requests.post('http://iot.dei.estg.ipleiria.pt/ti/ti088/api/api.php', data=payload_ACAmbiente)
            print(r.text)

        else:
            print(f"Erro na requisição. Código de status: {response_temperaturaArca.status_code}")
            
        if response_temperaturaArca.status_code == 200:
            temperaturaArca = float(response_temperaturaArca.text) 

            if temperaturaArca > -1:
                payload_ACArca['valor'] = '1'
                print("vou ligar o AC do supermercado")
            else:
                payload_ACArca['valor'] = '0'
                print("vou desligar o AC do supermercado")

            r=requests.post('http://iot.dei.estg.ipleiria.pt/ti/ti088/api/api.php', data=payload_ACArca)
            print(r.text)

        else:
            print(f"Erro na requisição. Código de status: {response_temperaturaArca.status_code}") 
       
        if response_humidade.status_code == 200:
            humidade = float(response_humidade.text) 

            if humidade > 60:
                payload_ACArca['valor'] = '1'
                print("vou ligar o AC do supermercado")
            else:
                payload_ACArca['valor'] = '0'
                print("vou desligar o AC do supermercado")

            r=requests.post('http://iot.dei.estg.ipleiria.pt/ti/ti088/api/api.php', data=payload_Desumidificador)
            print(r.text)

        else:
            print(f"Erro na requisição. Código de status: {response_humidade.status_code}") 
            
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
            
        if response_Portao.status_code == 200:
            ValorPortao = response_Portao.json()
            Portao_Estado = int(ValorPortao.get('valor', 0))

            if Portao_Estado == 1:
                payload_Portao['valor'] = '1'
                print("vou abrir o portao")

            else:
                payload_Portao['valor'] = '0'
                print("vou fechar o portao")
                
            r=requests.post('http://iot.dei.estg.ipleiria.pt/ti/ti088/api/api.php', data=payload_Portao)
            print(r.text)

        else:
            print(f"Erro na requisição. Código de status: {response_Portao.status_code}")    
            
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
