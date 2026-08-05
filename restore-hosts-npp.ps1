$ErrorActionPreference = "Stop"

$hostsPath = "C:\Windows\System32\drivers\etc\hosts"
$backupPath = "C:\Windows\System32\drivers\etc\hosts.codex-backup-20260805-224301"
$preRestoreBackup = "C:\Windows\System32\drivers\etc\hosts.before-restore-$(Get-Date -Format yyyyMMdd-HHmmss)"

Copy-Item -LiteralPath $hostsPath -Destination $preRestoreBackup -Force
$lines = Get-Content -LiteralPath $backupPath
$output = New-Object System.Collections.Generic.List[string]
$hasLocal = $false

foreach ($line in $lines) {
    if ($line -match '^\s*127\.0\.0\.1\s+.*\b(namedpatientprogram\.com|www\.namedpatientprogram\.com)\b') {
        if ($line -match '\bnamedpatientprogram\.local\b') {
            if (-not $hasLocal) {
                $output.Add("127.0.0.1 namedpatientprogram.local")
                $hasLocal = $true
            }
        }
        continue
    }

    if ($line -match '^\s*127\.0\.0\.1\s+.*\bnamedpatientprogram\.local\b') {
        if (-not $hasLocal) {
            $output.Add("127.0.0.1 namedpatientprogram.local")
            $hasLocal = $true
        }
        continue
    }

    $output.Add($line)
}

if (-not $hasLocal) {
    $output.Add("127.0.0.1 namedpatientprogram.local")
}

Set-Content -LiteralPath $hostsPath -Value $output -Encoding ASCII
ipconfig /flushdns

Write-Host "Restored hosts from: $backupPath"
Write-Host "Temporary empty-file backup: $preRestoreBackup"
Write-Host "Current Named Patient Program hosts entries:"
Select-String -Path $hostsPath -Pattern "namedpatientprogram"
Read-Host "Press Enter to close"
