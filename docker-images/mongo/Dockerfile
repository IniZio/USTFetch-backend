FROM mongo

# ADD create_db.js /tmp/

# RUN mongod -f /etc/mongod.conf --fork --logpath /var/log/mongodb.log \
#     && sleep 5 \
#     && mongo ustfetch /tmp/create_db.js

RUN mkdir -p /data/mongodb/db
RUN chmod -R 777 /data/mongodb/db