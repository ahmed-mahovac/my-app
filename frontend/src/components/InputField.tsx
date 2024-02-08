import React from "react";

interface InputFieldProps {
  label: string;
  type: string;
  value: string;
  onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
  placeholder: string;
  required: boolean;
};

export default function InputField({
  label,
  type,
  value,
  onChange,
  placeholder,
  required,
} : InputFieldProps) {
  return (
    <div className="mb-4">
      <label
        htmlFor={label}
        className="block text-sm font-medium text-gray-600"
      >
        {label}
      </label>
      <input
        type={type}
        id={label}
        name={label}
        value={value}
        onChange={onChange}
        placeholder={placeholder}
        className="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
        required={required}
      />
    </div>
  );
}
