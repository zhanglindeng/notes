### bat
- netsh

### Windows pwd
- Git Bash / MinGW
  - `docker run --rm -v /$(pwd):/root bash`
- Windows command prompt
  - `docker run --rm -v %cd%:/root bash`
