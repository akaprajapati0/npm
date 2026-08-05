$ErrorActionPreference = "Stop"

$hostsPath = "C:\Windows\System32\drivers\etc\hosts"
$backupPath = "C:\Windows\System32\drivers\etc\hosts.codex-backup-$(Get-Date -Format yyyyMMdd-HHmmss)"

Copy-Item -LiteralPath $hostsPath -Destination $backupPath -Force

$updated = foreach ($line in Get-Content -LiteralPath $hostsPath) {
    if ($line -match '^\s*127\.0\.0\.1\s+.*\b(namedpatientprogram\.com|www\.namedpatientprogram\.com)\b') {
        $keptLocal = ($line -match '\bnamedpatientprogram\.local\b')
        if ($keptLocal) {
            "127.0.0.1 namedpatientprogram.local"
        } else {
            "# " + $line
        }
    } else {
        $line
    }
}

Set-Content -LiteralPath $hostsPath -Value $updated -Encoding ASCII
ipconfig /flushdns

Write-Host "Backup saved at: $backupPath"
Write-Host "Current Named Patient Program hosts entries:"
Select-String -Path $hostsPath -Pattern "namedpatientprogram"
Read-Host "Press Enter to close"
