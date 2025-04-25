## Laravel DB Snapshots - Comandos Essenciais

### 1. Criar backup da tabela `users`

```bash
php artisan **snapshot**:create users-backup --table=users
```

### Restaurar esse backup

```bash
php artisan snapshot:load users-backup
```

---

### 2. Criar backup de **todas as tabelas**

```bash
php artisan snapshot:create backup
```

### Restaurar esse backup

```bash
php artisan snapshot:load backup
```

---

### 3. Restaurar snapshot sem apagar as tabelas existentes

```bash
php artisan snapshot:load nameSnapshot --drop-tables=0
```

---

## SNAPSHOTS - USO ESSENCIAL

### 1. Criar um snapshot de uma ou mais tabelas específicas

```bash
php artisan snapshot:create nameSnapshot --table=users
php artisan snapshot:create nameSnapshot --table=posts,users
php artisan snapshot:create nameSnapshot --table=posts --table=users
```

### 2. Restaurar um snapshot

```bash
php artisan snapshot:load nameSnapshot
```

### 3. Restaurar snapshot sem apagar as tabelas existentes

```bash
php artisan snapshot:load nameSnapshot --drop-tables=0
```

### 4. Restaurar usando streaming (útil p/ arquivos grandes)

```bash
php artisan snapshot:load nameSnapshot --stream
```

### 5. Criar snapshot excluindo algumas tabelas

```bash
php artisan snapshot:create nameSnapshot --exclude=logs,failed_jobs
```

### 6. Criar snapshot compactado (gzip)

```bash
php artisan snapshot:create nameSnapshot --compress
```

### 7. Criar snapshot sem nome → usa o timestamp como nome

```bash
php artisan snapshot:create
```

### 8. Criar snapshot com outra conexão (definida em `config/database.php`)

```bash
php artisan snapshot:create --connection=nome_da_conexao
```

### 9. Restaurar em uma conexão diferente

```bash
php artisan snapshot:load nameSnapshot --connection=nome_da_conexao
```

### 10. Listar todos os snapshots salvos

```bash
php artisan snapshot:list
```

### 11. Excluir um snapshot específico

```bash
php artisan snapshot:delete nameSnapshot
```

### 12. Manter apenas os 2 snapshots mais recentes

```bash
php artisan snapshot:cleanup --keep=2
```
