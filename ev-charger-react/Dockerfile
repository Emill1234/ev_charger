FROM node:14

WORKDIR /app/ev-charger-react

COPY package.json .
COPY package-lock.json .
RUN npm install

COPY . .

COPY ./src/axiosConfig.ts ./src/

RUN npm run build

RUN npm install -g serve
CMD ["serve", "-s", "build", "-l", "3000"]

EXPOSE 3000