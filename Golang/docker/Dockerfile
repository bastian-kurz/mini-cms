FROM golang:1.20-buster as builder

WORKDIR /src
COPY go.mod go.sum ./
RUN go mod download -x

COPY . .
RUN go build -o /bin/server cmd/*.go

FROM gcr.io/distroless/base-debian11

WORKDIR /app

COPY --from=builder /bin/server /src/internal/config/*.yaml ./

CMD ["./server"]