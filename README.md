# Fontray 🔤

Una aplicación web para identificación de fuentes tipográficas, construida con Laravel, Vue.js e Inertia.js.

## 🚀 Descripción del Proyecto

Fontray es una herramienta que permite a los usuarios identificar fuentes tipográficas a partir de imágenes. Simplemente sube una imagen con texto y nuestra aplicación te ayudará a identificar qué fuente se está utilizando.

### ✨ Características

- 📸 **Identificación por imagen**: Sube una imagen y obtén información detallada sobre las fuentes
- ✂️ **Recorte de imagen**: Herramientas integradas para recortar y optimizar la imagen antes del análisis
- 🎯 **Resultados precisos**: Integración con APIs especializadas en identificación tipográfica
- 📱 **Diseño responsive**: Funciona perfectamente en dispositivos móviles y desktop
- ⚡ **Rápido y eficiente**: Resultados en segundos

## 🛠️ Stack Tecnológico

- **Backend**: Laravel 11 con PHP 8.4
- **Frontend**: Vue.js 3 con Inertia.js
- **Base de Datos**: PostgreSQL
- **Contenedores**: Docker con Laravel Sail
- **Build Tool**: Vite
- **Despliegue**: Render.com

## 🏗️ Arquitectura

- **Monorepo**: Todo el código frontend y backend en un solo repositorio
- **API Externa**: Integración con [WhatFontIs API](https://www.whatfontis.com/API-identify-fonts-from-image.html) para identificación de fuentes
- **SPA**: Single Page Application con Inertia.js para una experiencia fluida

## 🚀 Configuración del Entorno de Desarrollo

### Prerrequisitos

- Docker Desktop instalado
- Git
- Cuenta en GitHub

### Instalación

1. **Clona el repositorio**:

   ```bash
   git clone https://github.com/tu-usuario/fontray.git
   cd fontray
   ```

2. **Configura las variables de entorno**:

   ```bash
   cp .env.example .env
   ```

   Edita el archivo `.env` y añade tu API key:

   ```
   WHATFONTIS_API_KEY=tu_clave_de_api_aqui
   ```

3. **Inicia el entorno con Sail**:

   ```bash
   ./vendor/bin/sail up -d
   ```

4. **Instala las dependencias**:

   ```bash
   ./vendor/bin/sail composer install
   ./vendor/bin/sail npm install
   ```

5. **Ejecuta las migraciones**:

   ```bash
   ./vendor/bin/sail artisan migrate
   ```

6. **Compila los assets**:

   ```bash
   ./vendor/bin/sail npm run dev
   ```

7. **Accede a la aplicación**:
   Abre tu navegador en `http://localhost`

### Comandos Útiles

```bash
# Iniciar el entorno
./vendor/bin/sail up -d

# Parar el entorno
./vendor/bin/sail down

# Ver logs
./vendor/bin/sail logs

# Ejecutar comandos Artisan
./vendor/bin/sail artisan [comando]

# Ejecutar comandos NPM
./vendor/bin/sail npm [comando]

# Acceder a la base de datos
./vendor/bin/sail psql

# Ejecutar tests
./vendor/bin/sail test
```

## 🤝 Cómo Contribuir

¡Las contribuciones son bienvenidas! Aquí te explicamos cómo puedes ayudar:

### 🐛 Reportar Bugs

1. Verifica que el bug no haya sido reportado anteriormente
2. Crea un nuevo issue con:
   - Descripción clara del problema
   - Pasos para reproducirlo
   - Comportamiento esperado vs actual
   - Screenshots si es necesario
   - Información del entorno (OS, navegador, etc.)

### 💡 Proponer Nuevas Características

1. Crea un issue describiendo:
   - La característica que propones
   - Por qué sería útil
   - Cómo crees que debería funcionar
   - Mockups o ejemplos si es posible

### 🔧 Contribuir con Código

1. **Fork** el repositorio
2. **Clona** tu fork:
   ```bash
   git clone https://github.com/tu-usuario/fontray.git
   ```
3. **Crea una rama** para tu característica:
   ```bash
   git checkout -b feature/nueva-caracteristica
   ```
4. **Desarrolla** tu característica siguiendo las convenciones del proyecto
5. **Prueba** tu código:
   ```bash
   ./vendor/bin/sail test
   ```
6. **Commit** tus cambios:
   ```bash
   git commit -m "feat: descripción de la nueva característica"
   ```
7. **Push** a tu fork:
   ```bash
   git push origin feature/nueva-caracteristica
   ```
8. **Abre un Pull Request** describiendo tus cambios

### 📝 Convenciones de Código

- **PHP**: Seguir PSR-12
- **JavaScript**: Seguir las convenciones de Vue.js
- **Commits**: Usar [Conventional Commits](https://www.conventionalcommits.org/)
- **Tests**: Escribir tests para nuevas características

### 🧪 Testing

```bash
# Ejecutar todos los tests
./vendor/bin/sail test

# Tests específicos
./vendor/bin/sail test --filter=NombreDelTest

# Tests con cobertura
./vendor/bin/sail test --coverage
```

## 📋 Roadmap

### 🎯 MVP (Fase 1)

- [x] Configuración del entorno con Laravel Sail
- [x] Configuración de PostgreSQL
- [x] Migraciones básicas
- [x] Controlador para identificación de fuentes
- [x] Componentes Vue.js para upload y recorte
- [x] Integración con WhatFontIs API
- [x] Página de resultados

### 🚀 Post-Lanzamiento (Fase 2)

- [x] Despliegue en Render.com
- [ ] Analíticas con Google Analytics
- [ ] Sistema de feedback
- [ ] Monitorización de errores

### 🌟 Futuro (Fase 3)

- [ ] Sistema de cuentas de usuario
- [ ] Historial de búsquedas
- [ ] Acceso a cámara en móviles
- [ ] API pública
- [ ] Múltiples proveedores de identificación

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

---

⭐ Si este proyecto te resulta útil, ¡dale una estrella en GitHub!
