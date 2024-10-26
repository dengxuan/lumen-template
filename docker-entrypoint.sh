#!/bin/bash

apachectl -D BACKGROUND

# 启动 Supervisor
supervisord -c /etc/supervisor/supervisord.conf