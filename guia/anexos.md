# Anexos

### Prueba del seis

 1. ¿Qué sitio es éste?
- La aplicación tiene en todo momento elementos indicativos de que sitio es. Arriba en la menú de navegación está en todo momento el logotipo de la aplicación. El menú de navegación y el pié de página se mantienen siempre, por lo que siempre está identificado el sitio.

 2. ¿En qué página estoy?
- Todas las páginas del sitio están identificadas por las migas de pan (excepto la inicial), lo que te sitúan en todo momento.

 3. ¿Cuales son las principales secciones del sitio?
- Las principales secciones del sitio son *Home*, *My Portrait* y *Contact* 

 4. ¿Qué opciones tengo en este nivel?
- La navegación de cada nivel se realiza mediante botones y enlaces para hacer uso de las diferentes acciones y pantallas.

 5. ¿Dónde estoy en el esquema de las cosas?
- En todas las páginas se muestra tanto el navbar como el sidebar que muestran todas las diferentes opciones de la web.

 6. ¿Cómo busco algo?
- En el inicio de mi sitio web aparece un buscador con el cual puedo localizar cualquier consulta creada.

---

### **([R25](https://github.com/joseckk/sharescode/issues/25)) Codeception**

![Pruebas Codeception](images/anexos/codeception.png)

---

### **([R26](https://github.com/joseckk/sharescode/issues/26)) Codeclimate**

![Pruebas Codeception](images/anexos/codeclimate.png)

---

### **([R33](https://github.com/joseckk/sharescode/issues/33)) Uso de microdatos**

![Pruebas Codeception](images/anexos/microdatos.png)

---

### **([R34](https://github.com/joseckk/sharescode/issues/34)) Validación HTML5, CSS3 y accesibilidad**
---
### Validación de HTML y CSS

**HTML**

![Validación HTML](images/anexos/validationHTML.png)

**CSS**

![Validación CSS](images/anexos/validationCSS.png)

**Accesibilidad**

![Validación accesibilidad](images/anexos/validationaccesibility.png)

---

### **([R36](https://github.com/joseckk/sharescode/issues/36)) Varios navegadores**

#### **Google Chrome**

![Captura Google Chrome](images/anexos/googlechrome.png)

---

#### **Mozilla Firefox**

![Captura Mozilla Firefox](images/anexos/mozillafirefox.png)

---

#### **Opera**

![Captura Opera](images/anexos/opera.png)

---

### **([R38](https://github.com/joseckk/sharescode/issues/38)) Despliegue en servidor local**

Configuración del servicio DHCP en el server:

![Despliegue local](images/anexos/dhcpserver1.png)

Configuración del servicio DHCP en el cliente:

![Despliegue local](images/anexos/dhcpclient.png)

Configuración del servicio DNS en el server:

* Creando las zonas en named.conf.local.

![Despliegue local](images/anexos/DNSnamedconflocal.png)

* Creando el fichero de configuración de la zona directa.

![Despliegue local](images/anexos/db-sharexxcode.png)

* Creando el fichero de configuración de la zona inversa.

![Despliegue local](images/anexos/db-192-168-1.png)

Configuración del servicio Apache en el server:

* Nueva configuración del netplan.

![Despliegue local](images/anexos/Apachenetplanservidor.png)

* Cambios en la configuración de la zona directa.

![Despliegue local](images/anexos/Apachezonadirectaserver.png)

* Cambios en la configuración de la zona inversa.

![Despliegue local](images/anexos/Apacheinversaservidor.png)

* Ahora configuraremos el fichero de sites-available para poner la ruta del proyecto y configurar directivas.

![Despliegue local](images/anexos/Apacheconfsitesavailable.png)

* Por último comprobaremos que al fin está desplegada nuestra aplicación desde la maquina cliente.

![Despliegue local](images/anexos/despliegefinalenlocal.png)
