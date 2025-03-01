# dockBox
DockBox is a simple local development environment based on Docker, designed to facilitate web development across multiple platforms.

<!-- ----------------------------------------------------------------------- -->

## Installation
```bash
git clone https://github.com/rocco-giandomenico/dockBox.git
cd dockBox
cp sample.env .env
docker compose up -d
```

```bash
docker compose exec --user dockbox webserver bash
```

<!-- ----------------------------------------------------------------------- -->

## Create Vue or React Apps
```bash
$ yarn create vite my-app --template vue
$ yarn create vite my-app --template react
```
### Development
```bash
cd my-app
yarn
yarn dev
```
vite.config.js
```
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  server: {
    host: '0.0.0.0',
    port: 5173
  }
})
```



<!-- ----------------------------------------------------------------------- -->

## License

**[MIT License](LICENSE)**