import time
import requests

print("Prima CTRL+C para terminar")

while True:
        try:
            # Pedido HTTP para obter valor do BTC
            response = requests.get("http://iot.dei.estg.ipleiria.pt/api/api.php?sensor=btc")

            if response.status_code == 200:
                data = response.json()
                print("Resposta JSON recebida:", data)  # Ver para confirmar a estrutura

                valor_BTC=response.json()

                print(f"Valor do BTC: {valor_BTC}")

                if valor_BTC > 99000:
                    print("vou ligar o LED do RPI")
                else:
                    print("vou desligar o LED do RPI")
            else:
                print(f"Erro na requisição. Código de status: {response.status_code}")

            time.sleep(5)

        except KeyboardInterrupt:
            # captura excecao CTRL + C
            print('\n O programa foi interrompido pelo utilizador.')
            break # sai do ciclo while
        except Exception as e:
            # captura todos os erros
            print('Erro inesperado:', e)
        finally:
            GPIO.cleanup()
            print('Terminou o programa')
