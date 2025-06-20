#include <WiFi101.h>
#include <ArduinoHttpClient.h>
#include <DHT.h>
#include <NTPClient.h>
#include <WiFiUdp.h> //Pré-instalada com o Arduino IDE
#include <TimeLib.h>

char SSID[] = "labs";
char PASS_WIFI[] = "1nv3nt@r2023_IPLEIRIA";

char URL[] = "iot.dei.estg.ipleiria.pt";
int PORTO = 80; // ou outro porto que esteja definido no servidor

WiFiClient clienteWifi;
HttpClient clienteHTTP = HttpClient(clienteWifi, URL, PORTO);

String enviaHumidade = "humidade";
String enviaTemp_amb = "temperatura_ambiente";
String enviaTemp_arc = "temperatura_arca";

#define DHTPIN 0 // Pin Digital onde está ligado o sensor
#define DHTTYPE DHT11 // Tipo de sensor DHT
DHT dht(DHTPIN, DHTTYPE); // Instanciar e declarar a class DHT

WiFiUDP clienteUDP;
//Servidor de NTP do IPLeiria: ntp.ipleiria.pt
//Fora do IPLeiria servidor: 0.pool.ntp.org
char NTP_SERVER[] = "ntp.ipleiria.pt";
NTPClient clienteNTP(clienteUDP, NTP_SERVER, 3600);

void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);
          
  while (!Serial);       // espera que o Serial Terminal seja inicializado

  WiFi.begin(SSID, PASS_WIFI);

  while (WiFi.status() != WL_CONNECTED){
    Serial.print(".");
    delay(500);
  }

  Serial.print("O Endereço IP --> ");
  Serial.println(WiFi.localIP());

  Serial.print("A máscara de rede --> ");
  Serial.println(WiFi.subnetMask());

  Serial.print("O Endereço IP do Default Gateway --> ");
  Serial.println(WiFi.gatewayIP());

  Serial.print("E a potência de Sinal --> ");
  Serial.println(WiFi.RSSI());

  pinMode(LED_BUILTIN, OUTPUT);

  dht.begin();
}


void post2API(String enviaNome,float enviaValor,String enviaHora) {

  String URLPath = "/ti/ti088/TI-Project-SmartMarket-/api/api.php"; //altere o grupo
  String contentType = "application/x-www-form-urlencoded";
  String body = "nome="+enviaNome+"&valor="+enviaValor+"&hora="+enviaHora;

  clienteHTTP.post(URLPath, contentType, body);

  //Enquanto a comunicação estiver ativa (connected), aguarda dados ficarem disponíveis(available)
  while(clienteHTTP.connected()){
    if (clienteHTTP.available()){
      int responseStatusCode = clienteHTTP.responseStatusCode();
      String responseBody = clienteHTTP.responseBody();
      Serial.println("Status Code: "+String(responseStatusCode)+" Resposta: "+responseBody);
    }
  }

}

void update_time(char *datahora){
  clienteNTP.update();
  unsigned long epochTime = clienteNTP.getEpochTime();
  sprintf(datahora, "%02d-%02d-%02d %02d:%02d:%02d", year(epochTime), month(epochTime), day(epochTime), hour(epochTime), minute(epochTime), second(epochTime));
}

void loop() {

  char datahora[20];
  update_time(datahora);

  float temperatura = dht.readTemperature();
  float humidade = dht.readHumidity();

  post2API(enviaTemp_amb, temperatura, datahora);
  post2API(enviaHumidade, humidade, datahora);
  post2API(enviaTemp_arc, temperatura, datahora);

//Condicionais get
//Temperatura AC
  clienteHTTP.get("/api/api.php?sensor=temperatura_ambiente");
  
  int statusCode = clienteHTTP.responseStatusCode();
  if (statusCode == 200) {
    String ServerRes = clienteHTTP.responseBody();
    Serial.print("Resposta do servidor: ");
    Serial.println(ServerRes);

    // Converte a resposta para float
    float temperaturaAC = ServerRes.toFloat();
    Serial.print("Temperatura obtida: ");
    Serial.println(temperaturaAC);

    // Verifica a temperatura AC
    if (temperaturaAC >= 20.0) {
      digitalWrite(LED_BUILTIN, HIGH); // Liga LED; AC do supermercado ligado para meter a temperatura suportavel
      Serial.println("Temperatura >= 20°C. LED ligado.");
    } else {
      digitalWrite(LED_BUILTIN, LOW);  // Desliga LED; AC desligado
      Serial.println("Temperatura < 20°C. LED desligado.");
    }

  } else {
    Serial.print("Erro HTTP, código: ");
    Serial.println(statusCode);
  }

  //Temperatura Arca
  clienteHTTP.get("/api/api.php?sensor=temperatura_arca");
  
  if (statusCode == 200) {
    String ServerRes = clienteHTTP.responseBody();
    Serial.print("Resposta do servidor: ");
    Serial.println(ServerRes);

    // Converte a resposta para float
    float temperaturaArca = ServerRes.toFloat()*-1;
    Serial.print("Temperatura obtida: ");
    Serial.println(temperaturaArca);

    // Verifica a temperatura AC
    if (temperaturaArca >= -1.0) {
      digitalWrite(LED_BUILTIN, HIGH); // Liga LED; AC da arca ligado para referigerar 
      Serial.println("Temperatura >= -1°C. LED ligado.");
    } else {
      digitalWrite(LED_BUILTIN, LOW);  // Desliga LED; AC desligado
      Serial.println("Temperatura < -1°C. LED desligado.");
    }

  } else {
    Serial.print("Erro HTTP, código: ");
    Serial.println(statusCode);
  }

  //Humidade 
  clienteHTTP.get("/api/api.php?sensor=humidade");

  if (statusCode == 200) {
    String ServerRes = clienteHTTP.responseBody();
    Serial.print("Resposta do servidor: ");
    Serial.println(ServerRes);

    // Converte a resposta para float
    float humidade = ServerRes.toFloat();
    Serial.print("Temperatura obtida: ");
    Serial.println(temperatura);

    // Verifica a temperatura AC
    if (temperatura >= 60.0) {
      digitalWrite(LED_BUILTIN, HIGH); // Liga LED; Aviso q é preciso Desumidificar
      Serial.println("Humidade >= 60%. LED ligado.");
    } else {
      digitalWrite(LED_BUILTIN, LOW);  // Desliga LED; Já n é preciso Desumidificar
      Serial.println("Temperatura < 60%. LED desligado.");
    }

  } else {
    Serial.print("Erro HTTP, código: ");
    Serial.println(statusCode);
  }
  
  delay(5000);
  
}
