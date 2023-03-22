FROM debian:latest
RUN apt update -yq && apt upgrade -yq && apt install -yq ftp && apt install -yq nmap net-tools && apt-get install -yq openssh-server && apt-get install -yq gobuster && apt-get install -yq sqlmap && apt-get install -yq curl && apt-get install -yq nano && apt-get install -yq iputils-ping && apt-get install -yq traceroute
RUN mkdir /var/run/sshd
RUN service ssh start
CMD ["/usr/sbin/sshd", "-D"]



