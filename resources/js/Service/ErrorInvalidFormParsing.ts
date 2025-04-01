
/**
 * Parses an error response and converts it into a single line error message.
 * 
 * @param {Record<string, string[]>} errors - The error object containing field-wise error messages.
 * @returns {string} A formatted string combining all error messages into one line.
 */
const parseErrorMessages = (errors: Record<string, string[]>): string => {
    return Object.values(errors)
      .flat() // Flatten nested error messages
      .join(', '); // Join all messages into a single string
  };
  
export default parseErrorMessages;          