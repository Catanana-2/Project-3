#include <WiFi.h>
#include <MySQL_Connection.h>
#include <MySQL_Cursor.h>

// ---- WIFI ----
char ssid[] = "iPhone";
char pass[] = "lasergamen";

// ---- MYSQL ----
IPAddress server_addr(192, 168, 1, 50);   // <-- jouw MySQL server IP
char user[] = "user";                     // <-- mysql username
char password[] = "pass";                 // <-- mysql password

WiFiClient client;
MySQL_Connection conn((Client *)&client);

String InputText = "";
int bolletjes = 0;

int led1 = 15;
int led2 = 2;

// ---- FUNCTION TO RUN QUERY ----
void runQuery() {
  if (!conn.connected()) {
    Serial.println("SQL is niet verbonden...");
    return;
  }

  Serial.println("Query starten...");

  // Maak cursor
  MySQL_Cursor *cur = new MySQL_Cursor(&conn);


  // Voer query uit
  cur->execute("SELECT platenumber FROM users.cars");

  // Kolomnamen (niet per se nodig, maar kan)
  column_names *cols = cur->get_columns();

  // Rijen ophalen
  row_values *row = NULL;

  Serial.println("Resultaten:");
  while ((row = cur->get_next_row())) {
    Serial.print(" - platenumber: ");
    Serial.println(row->values[0]);
  }

  delete cur;  // cursor opruimen
  Serial.println("Klaar.\n");
}

void setup() {
  Serial.begin(115200);
  delay(2000);
  pinMode(led1, OUTPUT);
  pinMode(led2, OUTPUT);
  digitalWrite(led1, HIGH);  // aan

  digitalWrite(led2, LOW);  // aan

  Serial.println("Verbinden met WiFi...");
  WiFi.begin(ssid, pass);

  while (WiFi.status() != WL_CONNECTED) {
   if(bolletjes < 4){
    Serial.print(".");
    delay(500);
    bolletjes += 1;
   }
   else{
    Serial.println(".");
    delay(500);
    bolletjes = 0;
   }
    
  }

  Serial.println("\nWiFi verbonden!");
  Serial.print("IP: ");
  Serial.println(WiFi.localIP());

  Serial.println("Verbinden met MySQL...");

  if (conn.connect(server_addr, 3306, user, password)) {
    Serial.println("MySQL verbonden!");
    digitalWrite(led2, HIGH);  // aan
  } else {
    Serial.println("MySQL verbinding mislukt!");
  }

  Serial.println("Typ iets in de serial om een query uit te voeren.");
}

void loop() {
  if (Serial.available() > 0) {
    InputText = Serial.readString();   // de input zelf maakt niet uit
    Serial.print("Je hebt dit getypt: ");
    Serial.println(InputText);
    runQuery();
  }
}
