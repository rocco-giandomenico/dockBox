# dockBox
DockBox is a simple local development environment based on Docker, designed to facilitate web development across multiple platforms.

<!-- ----------------------------------------------------------------------- -->

## Installation
```bash
git clone https://github.com/rocco-giandomenico/dockbox.git
cd dockbox
cp sample.env .env
docker compose up -d
```

```bash
docker compose exec --user dockbox webserver bash -l
```

<!-- ----------------------------------------------------------------------- -->

## License

**[MIT License](LICENSE)**