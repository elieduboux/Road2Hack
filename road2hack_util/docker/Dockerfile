FROM debian:latest

RUN apt update -yq && apt upgrade -yq && apt install -yq ftp && apt install -yq nmap net-tools && apt-get install -yq openssh-server && apt-get install -yq gobuster && apt-get install -yq sqlmap && apt-get install -yq curl && apt-get install -yq nano && apt-get install -yq iputils-ping && apt-get install -yq traceroute
 
#ssh-server
RUN useradd -rm -d /home/debian -s /bin/bash -g root -G sudo -u 1000 branleur

RUN  echo 'branleur:pswd' | chpasswd

RUN service ssh start

EXPOSE 22

CMD ["/usr/sbin/sshd","-D"]
