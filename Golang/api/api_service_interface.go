package api

import "net/http"

type ApiServiceInterface interface {
	// Get tries to fetch data by given id, if successfully a detail response will be returned.
	// If an error occurred an 404 or 505 error message will be responded.
	Get(w http.ResponseWriter, r *http.Request)

	// List will fetch all objects in the database if no object is found an empty response will be returned.
	List(w http.ResponseWriter, r *http.Request)

	// Create validates incoming request and if validation succeed it wil persist the data into the database
	Create(w http.ResponseWriter, r *http.Request)

	// Update loads resource by given id, validates new data and stores them if no error occur
	Update(w http.ResponseWriter, r *http.Request)

	// Delete deletes a resource by a given id and returns 204 No Content if successfully
	Delete(w http.ResponseWriter, r *http.Request)
}
