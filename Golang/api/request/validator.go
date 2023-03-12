package request

import "github.com/go-playground/validator/v10"

func IsValidStruct(s any) error {
	validate := validator.New()

	// returns nil or ValidationErrors ( []FieldErrors )
	err := validate.Struct(s)
	if err != nil {
		return err.(validator.ValidationErrors)
	}

	return nil
}
