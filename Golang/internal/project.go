package internal

import (
	"path/filepath"
	"runtime"
)

var (
	_, b, _, _ = runtime.Caller(0)
	Root       = filepath.Join(filepath.Dir(b), "../") + "/"
	ConfigDir  = Root + "internal/config/"
)
