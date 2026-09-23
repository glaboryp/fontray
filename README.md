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

## 🏗️ Arquitectura

- **Monorepo**: Todo el código frontend y backend en un solo repositorio
- **API Externa**: Integración con [WhatFontIs API](https://www.whatfontis.com/API-identify-fonts-from-image.html) para identificación de fuentes
- **SPA**: Single Page Application con Inertia.js para una experiencia fluida

## 🚀 Configuración del Entorno de Desarrollo

### Prerrequisitos

- Docker
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
   ./vendor/bin/sail pnpm install
   ```

5. **Ejecuta las migraciones**:

   ```bash
   ./vendor/bin/sail artisan migrate
   ```

6. **Compila los assets**:

   ```bash
   ./vendor/bin/sail pnpm run dev
   ```

7. **Accede a la aplicación**:
   Abre tu navegador en `http://localhost:8080` (puerto definido por `APP_PORT` en tu `.env`).

   > **Nota**: usamos `APP_PORT=8080` en vez del 80 por defecto para evitar
   > choques con otros proyectos Docker que también reclaman el puerto 80.
   > Si tienes un `http://localhost/` que no muestra Fontray, revisa el valor
   > de `APP_PORT` en tu `.env` y entra por ese puerto. Si 8080 también está
   > ocupado en tu máquina, cambia `APP_PORT` a otro valor libre.

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

# Ejecutar comandos pnpm
./vendor/bin/sail pnpm [comando]

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

Fontray ahora tiene 3 capas de tests:

1. **Backend (PHPUnit / Laravel)**
2. **Frontend unit/component (Vitest + Vue Test Utils)**
3. **E2E (Playwright)**

#### Opción A — Ejecutar tests en local (sin Sail)

```bash
# Backend (Laravel/PHPUnit)
php artisan test

# Frontend unit/component
pnpm run test
# o en watch mode
pnpm run test:watch

# E2E
pnpm run test:e2e
```

#### Opción B — Ejecutar tests con Sail

```bash
# Backend
./vendor/bin/sail artisan test

# Frontend unit/component
./vendor/bin/sail pnpm run test

# E2E
./vendor/bin/sail pnpm run test:e2e
```

#### Comandos útiles de filtrado

```bash
# Solo un test PHP
php artisan test --filter=FontIdentificationServiceTest

# Solo un archivo de Vitest
pnpm exec vitest run resources/js/Pages/__tests__/ResultsPage.test.js

# Solo un archivo E2E
pnpm exec playwright test e2e/font-identification.spec.js
```

#### Nota sobre entorno para E2E

Los tests E2E están configurados para levantar Laravel en modo testing y evitar dependencias externas:

- `APP_ENV=testing`
- `WHATFONTIS_MOCK=true`
- `DB_CONNECTION=sqlite`

Esto evita llamadas reales a WhatFontIs y hace los tests reproducibles.

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

- [x] Despliegue en AWS
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
